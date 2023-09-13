<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnalysisResultParseRequest;
use App\Models\Customer;
use App\Models\CustomerState;
use Illuminate\Http\Request;

class AnalysisResultController extends Controller
{
    /**
     * Parses analysis result and saves customer and customer state data into database.
     *
     * @param AnalysisResultParseRequest $request
     * @return \Illuminate\Http\JsonResponse ['status', 'message'] 
     */
    public function parse(AnalysisResultParseRequest $request)
    {
        // Get the file and its content.
        $file = $request->file('file');
        $content = file_get_contents($file->path());
        $data = json_decode($content);

        // Update or create the customer based on configuration ID and email.
        $customer = Customer::updateOrCreate(
            [
                'config_id' => $request->config_id,
                'email' => $data->email,
            ],
            [
                'config_id' => $request->config_id,
                'email' => $data->email,
            ]
        );

        // Convert the analysis date string to the desired format.
        $analysisDate = $this->convertAnalysisDateStringToDateFormat($data->analysis_date);

        // Create the customer's customer_state record.
        $customerState = $customer->states()->create([
            'plans' => $data->current_plan,
            'predicted_plan' => $data->predicted_plan,
            'date' => $analysisDate,
            'state' => $data->states
        ]);

        // Prepare the JSON response.
        return response()->json([
            'success' => true,
            'message' => 'Analysis result parsed successfully',
            'data' => ['customer' => $customer->load('latestState')]
        ], 200);
    }

    /**
     * Convert a string date like "20230615" to a formatted date like "2023/06/15".
     *
     * @param string $stringDate The input string date.
     * @return string The formatted date.
     */
    public function convertAnalysisDateStringToDateFormat($stringDate)
    {
        $year = substr($stringDate, 0, 4);
        $month = substr($stringDate, 4, 2);
        $day = substr($stringDate, 6, 2);

        return $year . '/' . $month . '/' . $day;
    }
}