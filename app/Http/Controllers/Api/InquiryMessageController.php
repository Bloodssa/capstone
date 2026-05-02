<?php

namespace App\Http\Controllers\Api;

use App\Enum\InquiryResponseType;
use App\Http\Controllers\Controller;
use App\Http\Resources\InquiryMessageResource;
use App\Models\InquiryResponse;
use App\Models\WarrantyInquiries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InquiryMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'warranty_inquiries_id' => ['required', 'numeric', 'exists:warranty_inquiries,id'],
            'message' => ['required', 'string'],
            "type" => ['required', Rule::enum(InquiryResponseType::class)],
            'attachments.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120']
        ]);

        $data['user_id'] = Auth::id();

        // handle the image path and it will be stored as a json
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('inquiries', 'public');
            }
        }

        $data['attachments'] = $attachmentPaths;
        $inquiryResponse = InquiryResponse::create($data);

        // when the tech or customer reply to the inquiry update the updated_at in the WarrantyInquiry
        $inquiryResponse->warrantyInquiries->touch();
        $inquiryResponse->load('user'); // load user for resource

        return response()->json([
            'message' => 'Response Submitted',
            'data' => new InquiryMessageResource($inquiryResponse)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = WarrantyInquiries::with('warranty.product', 'user', 'responses.user')
            ->findOrFail($id);

        // collect and combine inquiry and messages
        $messages = $this->inquiryMessages(collect([$inquiry]));

        return InquiryMessageResource::collection($messages);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inquiryResponse = InquiryResponse::findOrFail($id);
        
        // update to auth id, this is temporary
        if ($inquiryResponse->user_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'message' => ['required', 'string'],
            'type' => ['required', Rule::enum(InquiryResponseType::class)]
        ]);

        $inquiryResponse->update($data);

        return response()->json([
            'message' => 'Message text updated',
            'data' => new InquiryMessageResource($inquiryResponse->load('user'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inquiryResponse = InquiryResponse::findOrFail($id);

        // update to auth id, this is temporary
        if ($inquiryResponse->user_id !== 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // if the inquiry message has attached images etc then delete it in the storage
        if(!empty($inquiryResponse->attachments)) {
            foreach($inquiryResponse->attachments as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $inquiryResponse->delete();

        return response()->json([
            "message" => 'Message and attachments deleted'
        ], 200);
    }

    /**
     * Temporary Messages Helper
     */
    protected function inquiryMessages($inquiries)
    {
        $messages = collect();

        foreach ($inquiries as $inquiry) {
            // append the inquiry message first to the collections for first message
            $messages->push($this->formatInquiryMessage(
                $inquiry->id,
                'message',
                $inquiry->message,
                $inquiry->user,
                $inquiry->created_at,
                $inquiry->attachments,
                $inquiry->status
            ));

            // inquiry responses with the type if updates, solution or message of admin or customer
            foreach ($inquiry->responses as $response) {
                $messages->push($this->formatInquiryMessage(
                    $response->id,
                    $response->type,
                    $response->message,
                    $response->user,
                    $response->created_at,
                    $response->attachments,
                    $inquiry->status
                ));
            }
        }

        // sort created because this is all the warranty inquiries to be in sequence of the date
        return $messages->sortBy('created_at')->values();
    }

    /**
     * Helper for mapping the inquiry message format
     * 
     * @param string type of the message
     * @param string message the message
     * @param App/Models/User the onw who respond
     * @param date when its created
     * @param json or casted into array attachments such us image of the inquiry
     * @param status the status of inquiry
     */
    private function formatInquiryMessage($id, $type, $message, $user, $date, $attachments = [], $status = null): object
    {
        return (object)[
            'id' => $id,
            'type' => $type,
            'message' => $message,
            'user' => $user,
            'created_at' => $date,
            'attachments' => $attachments ?? [],
            'status' => $status,
        ];
    }
}
