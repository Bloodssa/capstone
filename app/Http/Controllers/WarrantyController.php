<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\WarrantyInvitation;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Warranty;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\WarrantyInquiries;
use App\Models\InquiryResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function inquire(Request $request)
    {
        $errors = new MessageBag(); // for modification of the error message

        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');

            if (count($files) > 10) { // limit for 10 files
                return back()->withErrors([
                    'attachments' => 'You are only allowed to upload a maximum of 10 images.'
                ])->withInput();
            }

            foreach ($files as $index => $file) {
                if (!$file->isValid()) {
                    $filename = $file->getClientOriginalName();
                    $errors->add("attachments.$index", "$filename failed to upload.");
                }
            }
        }

        $validator = Validator::make(
            $request->all(),
            [
                'warranty_id' => ['required', 'numeric', 'exists:warranties,id'],
                'message' => ['required', 'string'],
                'attachments' => ['nullable', 'array', 'max:10'],
                'attachments.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            ],
            [
                'attachments.max' => 'You are only allowed to upload a maximum of 10 images.',
                'attachments.*.image' => 'Each file must be an image.',
                'attachments.*.mimes' => 'Only jpeg, png, jpg, webp formats are allowed.',
                'attachments.*.max' => 'Each image must not exceed 10MB.',
            ]
        );
        if ($validator->fails() || $errors->isNotEmpty()) {
            $validationErrors = $validator->errors();

            $allErrors = $validationErrors->merge($errors);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $index => $file) {
                    $key = "attachments.$index";

                    if ($allErrors->has($key)) {
                        $filename = $file->getClientOriginalName();

                        $messages = $allErrors->get($key);
                        $allErrors->forget($key);

                        foreach ($messages as $message) {
                            if (!str_contains($message, $filename)) {
                                $allErrors->add($key, "$filename: $message");
                            } else {
                                $allErrors->add($key, $message);
                            }
                        }
                    }
                }
            }
            return back()->withErrors($allErrors)->withInput();
        }

        $data = $validator->validated();
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'open';

        // handle the image path and it will be stored as a json
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('inquiries', 'public');
            }
        }

        $data['attachments'] = $attachmentPaths;

        $inquiries = WarrantyInquiries::create($data);

        return back()->with('success', 'Inquiry Submitted');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function response(Request $request)
    {
        // dd($request);
        $data = $request->validate([
            'warranty_inquiries_id' => ['required', 'numeric', 'exists:warranty_inquiries,id'],
            'message' => ['required', 'string'],
            'attachments.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120']
        ]);

        $data['user_id'] = Auth::user()->id;

        // handle the image path and it will be stored as a json
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('inquiries', 'public');
            }
        }

        $data['attachments'] = $attachmentPaths;

        $inquiries = InquiryResponse::create($data);

        // when the tech or customer reply to the inquiry update the updated_at in the WarrantyInquiry
        $inquiries->warrantyInquiries->touch();

        return back()->with('success', 'Inquiry Response Submitted');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'product_id' => ['required', 'exists:products,id'],
            'serial_number' => ['required', 'string', 'unique:warranties,serial_number'],
            'purchase_date' => ['required', 'date']
        ]);

        $user = User::where('email', $data['email'])->first('id');

        // get the product for the warranty duration
        $product = Product::findOrFail($data['product_id']);

        // PARSE THE DATE
        $purchaseDate = Carbon::parse($request->purchase_date);
        $expiryDate = $purchaseDate->copy()->addMonths($product->warranty_duration);

        $warrantyPayload = [
            'product_id' => $product->id,
            'serial_number' => $data['serial_number'],
            'purchase_date' => $purchaseDate,
            'expiry_date' => $expiryDate,
            'status' => $user ? 'active' : 'pending',
            'is_claimed' => $user ? true : false
        ];

        if ($user) {
            $warrantyPayload['user_id'] = $user['id'];
        }

        $warranty = Warranty::create($warrantyPayload);

        if (! $user) {
            // assigned a registration url for claim and email to the customer
            $registrationLink = URL::temporarySignedRoute('customer.claim', $warranty->expiry_date, ['serial' => $warranty->serial_number]);

            $warranty->load('product');

            // send an invitation mail to customer account registration with the created url with hash for security purposes
            Mail::to($request->email)->send(new WarrantyInvitation($warranty, $request->email, $registrationLink));
        }

        return redirect('register-warranty')->with('status', 'Warranty created and email sent!');
    }

    /**
     * @param string serial num of the product from the request uri wildcard
     * 
     * Display the specified resource.
     */
    public function show(string $serial)
    {
        // get the serial number of the product from the query string
        $warrantyClaim = Warranty::where('serial_number', $serial)->where('is_claimed', false)->firstORFail();

        // throw 403 that warranty is already claim
        if ($warrantyClaim->is_claimed) {
            abort(403, 'Warranty already claimed.');
        }

        // guard for the warranty expiration
        if (now()->greaterThan($warrantyClaim->expiry_date)) {
            abort(403, 'Warranty already expired.');
        }

        // add session for claiming the warranty
        session(['claim_warranty' => $warrantyClaim->id]);

        return view('auth.register', [
            'warranty' => $warrantyClaim,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'status' => ['required', 'string'],
            'resolved_message' => ['nullable', 'string']
        ]);

        // dd($request);
        $inquiry = WarrantyInquiries::findOrFail($id);
        $previousStatus = $inquiry->status;

        $inquiry->update([
            'status' => $data['status']
        ]);

        $resolvedMessage = $data['resolved_message'] ?? null;

        $inquiry->responses()->create([
            'user_id' => Auth::user()->id,
            'message' => $data['resolved_message'] ?? "Status changed from " . ucfirst($previousStatus) . " to " . ucfirst($data['status']),
            'type' => $resolvedMessage ? 'solution' : 'updates'
        ]);

        return back()->with('success', 'Inquiry status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
