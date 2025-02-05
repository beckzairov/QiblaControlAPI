<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\AgreementResource;
use Carbon\Carbon;

class AgreementController extends Controller
{
    /**
     * Display a listing of the agreements.
     */
    public function index()
    {
        // Use Eloquent to fetch all agreements
        $agreements = Agreement::with('responsibleUser', 'creator', 'customerLists')->get();

        // Return as a resource collection
        return response()->json(AgreementResource::collection($agreements));
    }

    /**
     * Store a newly created agreement in storage.
     */
    public function store(Request $request)
    {
        // return response()->json(1);
        // return response()->json($request->validate(['responsible_user_id' => 'required|exists:users,id']));
        $validated = $request->validate([
            'flight_date' => 'required|date',
            'duration_of_stay' => 'required|integer',
            'client_name' => 'required|string|max:255',
            'client_relatives' => 'nullable|string|max:255',
            'tariff_name' => 'required|string|max:255',
            'room_type' => 'required|string|max:255',
            'transportation' => 'required|string|max:255',
            'exchange_rate' => 'required|numeric',
            'total_price' => 'required|numeric',
            'payment_paid' => 'required|numeric',
            'phone_numbers' => 'required|array',
            'previous_agreement_taken_away' => 'nullable|boolean',
            'comments' => 'nullable|string',
            'responsible_user_id' => 'required|exists:users,id',
        ]);
        
        $flight_date = Carbon::createFromFormat('Y-m-d', $validated['flight_date'])->toDateTimeString();
        $validated['flight_date'] = $flight_date;
        // Create a new agreement
        $agreement = Agreement::create([
            ...$validated,
            'created_by_id' => auth()->id(),
        ]);

        return new AgreementResource($agreement);
    }

    /**
     * Display the specified agreement.
     */
    public function show(Agreement $agreement)
    {
        // Use a resource for clean JSON response
        return new AgreementResource($agreement->load('responsibleUser', 'creator', 'customerLists'));
    }

    /**
     * Update the specified agreement in storage.
     */
    public function update(Request $request, Agreement $agreement)
    {
        // dd(1);
        // Allow users to update agreements
        Gate::authorize('update', $agreement);

        // If the responsible_user_id is being updated, only allow Admins
        if ($request->has('responsible_user_id')) {
            Gate::authorize('updateResponsibleUser', $agreement);
            $agreement->update([
                'responsible_user_id' => $request->responsible_user_id
            ]);
        }

        $validated = $request->validate([
            'flight_date' => 'sometimes|date',
            'duration_of_stay' => 'sometimes|integer',
            'client_name' => 'sometimes|string|max:255',
            'client_relatives' => 'nullable|string|max:255',
            'tariff_name' => 'sometimes|string|max:255',
            'room_type' => 'sometimes|string|max:255',
            'transportation' => 'sometimes|string|max:255',
            'exchange_rate' => 'sometimes|numeric',
            'total_price' => 'sometimes|numeric',
            'payment_paid' => 'sometimes|numeric',
            'phone_numbers' => 'sometimes|array',
            'previous_agreement_taken_away' => 'nullable|boolean',
            'comments' => 'nullable|string',
        ]);

        $agreement->update($validated);

        return response()->json(['message' => 'Agreement updated successfully.', 'agreement' => $agreement], 200);
    }



    /**
     * Remove the specified agreement from storage.
     */
    public function destroy(Agreement $agreement)
    {
        $agreement->delete();

        return response()->json(['message' => 'Agreement deleted successfully.'], 200);
    }
}
