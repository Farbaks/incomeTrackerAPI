<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Job;
use App\Models\Quotation;
use App\Models\Item;
use App\Models\Payment;
use Event;
use App\Events\ResetPassword;
use PDF;

class JobController extends Controller
{
    //funciton to create a job
    public function createJob(Request $request)
    {
        $data = Validator::make($request->all(), [
            'companyName' => 'required|max:255',
            'contactName' => 'required',
            'contactNumber' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }
        $job = new Job;
        $job->companyName = $request->companyName;
        $job->contactName = $request->contactName;
        $job->contactNumber = $request->contactNumber;
        $job->status = "Pending Quotation Creation";
        $job->comment = "";
        if ($request->comment) {
            $job->comment = $request->comment;
        }
        $job->userId = $request->userID;

        $job->save();
        // $newJob = Job::find($job->id);
        $checkQuotation = Quotation::where('jobId', $job->id)->first();

        if ($checkQuotation == "") {
            $job->quotation = "Quotation has not been created";
            return response()->json([
                'status' => 200,
                'message' => 'Job has been created successfully',
                'data' => $job
            ], 200);
        }

        $job->quotation = [
            Quotation::where('jobId', $job->id)->first(),
            'items' => Item::where('jobId', $job->id)->get(),
            'tax' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->get(),
            'discount' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->get()
        ];
        return response()->json([
            'status' => 200,
            'message' => 'Job has been created successfully',
            'data' => $job
        ], 200);
    }

    //funciton to edit a job
    public function editJob(Request $request)
    {
        $data = Validator::make($request->all(), [
            'jobId' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }

        $job = Job::find($request->jobId);

        if ($job == "") {
            return response()->json([
                'status' => 400,
                'message' => 'Job does not exist',
                'data' => $job
            ], 400);
        }
        $job->update([
            'status' => $request->status
        ]);

        $checkQuotation = Quotation::where('jobId', $job->id)->first();

        if ($checkQuotation == "") {
            $job->quotation = "Quotation has not been created";
            return response()->json([
                'status' => 200,
                'message' => 'Job has been updated successfully',
                'data' => $job
            ], 200);
        }

        $job->quotation = [
            Quotation::where('jobId', $job->id)->first(),
            'items' => Item::where('jobId', $job->id),
            'discount' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')
        ];
        return response()->json([
            'status' => 200,
            'message' => 'Job has been created successfully',
            'data' => $job
        ], 200);
    }

    //funciton to create a quotation
    public function createQuotation(Request $request)
    {
        $data = Validator::make($request->all(), [
            'salesPerson' => 'required',
            'quotationValidity' => 'required',
            'paymentTerms' => 'required',
            'currency' => 'required',
            'subTotalJobCost' => 'required',
            'totalJobCost' => 'required',
            'profit' => 'required',
            'jobId' => 'required|numeric',
            'items' => 'required',
            'payments' => 'required'
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }

        $job = Job::find($request->jobId);

        if ($job == "") {
            return response()->json([
                'status' => 400,
                'message' => 'Job does not exist',
                'data' => $job
            ], 400);
        }

        $checkQuotation = Quotation::where('jobId', $job->id)->first();

        if ($checkQuotation != "") {
            $job->quotation = "Quotation has already been created";
            return response()->json([
                'status' => 400,
                'message' => 'Job has been updated successfully',
                'data' => $job
            ], 400);
        }

        $quotation = new Quotation;
        $quotation->salesPerson = $request->salesPerson;
        $quotation->quotationValidity = $request->quotationValidity;
        $quotation->paymentTerms = $request->paymentTerms;
        $quotation->refNumber = NULL;
        if ($request->refNumber) {
            $quotation->refNumber = $request->refNumber;
        }
        $quotation->deliveryDate = NULL;
        if ($request->deliveryDate) {
            $quotation->deliveryDate = $request->deliveryDate;
        }
        $quotation->currency = $request->currency;
        $quotation->subTotalJobCost = $request->subTotalJobCost;
        $quotation->totalJobCost = $request->totalJobCost;
        $quotation->profit = $request->profit;
        $quotation->comment = "";
        if ($request->comment) {
            $quotation->comment = $request->comment;
        }
        $quotation->userId = $request->userID;
        $quotation->jobId = $request->jobId;

        $quotation->save();

        foreach ($request->items as $items) {
            Item::create([
                'itemName' => $items['itemName'],
                'UOM' => $items['UOM'],
                'unitPrice' => $items['unitPrice'],
                'quantity' => $items['quantity'],
                'totalPrice' => $items['totalPrice'],
                'userId' => $request->userID,
                'jobId' => $request->jobId,
                'quotationId' => $quotation->id,
            ]);
        }

        foreach ($request->payments as $payments) {
            Payment::create([
                'paymentName' => $payments['paymentName'],
                'paymentType' => $payments['paymentType'],
                'amount' => $payments['amount'],
                'userId' => $request->userID,
                'jobId' => $request->jobId,
                'quotationId' => $quotation->id,
            ]);
        }

        $job->update([
            'status' => "Pending Quotation Approval"
        ]);

        $job->quotation = [
            'quotationDetails' => Quotation::where('jobId', $job->id)->first(),
            'items' => [
                'totalNumber' => Item::where('jobId', $job->id)->count(),
                'totalAmount' => Item::where('jobId', $job->id)->get('totalPrice')->sum('totalPrice'),
                'itemList' => Item::where('jobId', $job->id)->get(),
            ],

            'tax' => [
                'totalAmount' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->get('amount')->sum('amount'),
                'totalNumber' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->count(),
                'taxList' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->get()
            ],
            'discount' => [
                'totalAmount' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->get('amount')->sum('amount'),
                'totalNumber' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->count(),
                'discountList' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->get()
            ]
        ];
        return response()->json([
            'status' => 200,
            'message' => 'Quotation has been created successfully',
            'data' => $job
        ], 200);
    }

    //funciton to create a quotation
    public function editQuotation(Request $request)
    {
        $data = Validator::make($request->all(), [
            'salesPerson' => 'required',
            'quotationValidity' => 'required',
            'paymentTerms' => 'required',
            'currency' => 'required',
            'subTotalJobCost' => 'required',
            'totalJobCost' => 'required',
            'profit' => 'required',
            'jobId' => 'required|numeric',
            'items' => 'required',
            'payments' => 'required'
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }

        $job = Job::find($request->jobId);

        if ($job == "") {
            return response()->json([
                'status' => 400,
                'message' => 'Job does not exist',
                'data' => $job
            ], 400);
        }

        $quotation = Quotation::where('jobId', $job->id)->first();

        if ($quotation == "") {
            $job->quotation = "Quotation has not been created";
            return response()->json([
                'status' => 400,
                'message' => 'Job has been updated successfully',
                'data' => $job
            ], 400);
        }

        $quotation->salesPerson = $request->salesPerson;
        $quotation->quotationValidity = $request->quotationValidity;
        $quotation->paymentTerms = $request->paymentTerms;
        $quotation->refNumber = NULL;
        if ($request->refNumber) {
            $quotation->refNumber = $request->refNumber;
        }
        $quotation->deliveryDate = NULL;
        if ($request->deliveryDate) {
            $quotation->deliveryDate = $request->deliveryDate;
        }
        $quotation->currency = $request->currency;
        $quotation->subTotalJobCost = $request->subTotalJobCost;
        $quotation->totalJobCost = $request->totalJobCost;
        $quotation->profit = $request->profit;
        $quotation->comment = "";
        if ($request->comment) {
            $quotation->comment = $request->comment;
        }
        $quotation->userId = $request->userID;
        $quotation->jobId = $request->jobId;

        $quotation->update();

        Item::where('jobId', $quotation->jobId)->delete();
        Payment::where('jobId', $quotation->jobId)->delete();

        foreach ($request->items as $items) {
            Item::create([
                'itemName' => $items['itemName'],
                'UOM' => $items['UOM'],
                'unitPrice' => $items['unitPrice'],
                'quantity' => $items['quantity'],
                'totalPrice' => $items['totalPrice'],
                'userId' => $request->userID,
                'jobId' => $request->jobId,
                'quotationId' => $quotation->id,
            ]);
        }

        foreach ($request->payments as $payments) {
            Payment::create([
                'paymentName' => $payments['paymentName'],
                'paymentType' => $payments['paymentType'],
                'amount' => $payments['amount'],
                'userId' => $request->userID,
                'jobId' => $request->jobId,
                'quotationId' => $quotation->id,
            ]);
        }

        $job->quotation = [
            'quotationDetails' => Quotation::where('jobId', $job->id)->first(),
            'items' => [
                'totalNumber' => Item::where('jobId', $job->id)->count(),
                'totalAmount' => Item::where('jobId', $job->id)->get('totalPrice')->sum('totalPrice'),
                'itemList' => Item::where('jobId', $job->id)->get(),
            ],

            'tax' => [
                'totalAmount' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->get('amount')->sum('amount'),
                'totalNumber' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->count(),
                'taxList' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->get()
            ],
            'discount' => [
                'totalAmount' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->get('amount')->sum('amount'),
                'totalNumber' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->count(),
                'discountList' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->get()
            ]
        ];
        return response()->json([
            'status' => 200,
            'message' => 'Quotation has been updated successfully',
            'data' => $job
        ], 200);
    }

    //funciton to get one job
    public function getJob($id)
    {
        $job = Job::find($id);

        if ($job == "") {
            return response()->json([
                'status' => 400,
                'message' => 'Job does not exist',
                'data' => $job
            ], 400);
        }

        $quotation = Quotation::where('jobId', $job->id)->first();

        if ($quotation == "") {
            $job->quotation = "Quotation has not been created";
            return response()->json([
                'status' => 200,
                'message' => 'Job has been updated successfully',
                'data' => $job
            ], 200);
        }

        $job->quotation = [
            'quotationDetails' => $quotation,
            'items' => [
                'totalNumber' => Item::where('jobId', $job->id)->count(),
                'totalAmount' => Item::where('jobId', $job->id)->get('totalPrice')->sum('totalPrice'),
                'itemList' => Item::where('jobId', $job->id)->get(),
            ],

            'tax' => [
                'totalAmount' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->get('amount')->sum('amount'),
                'totalNumber' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->count(),
                'taxList' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->get()
            ],
            'discount' => [
                'totalAmount' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->get('amount')->sum('amount'),
                'totalNumber' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->count(),
                'discountList' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->get()
            ]
        ];
        return response()->json([
            'status' => 200,
            'message' => 'Quotation has been updated successfully',
            'data' => $job
        ], 200);
    }

    //funciton to get multiple jobs
    public function getAllJobs(Request $request)
    {
        $data = Validator::make($request->all(), [
            'offset' => 'required|numeric',
            'limit' => 'required|numeric'
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'All fields are required',
                'data' => []
            ], 400);
        }

        $jobs = Job::where('userId', $request->userID)->latest()
            ->offset($request->offset)
            ->limit($request->limit)
            ->get();

        if ($jobs == "") {
            return response()->json([
                'status' => 200,
                'message' => 'No jobs found',
                'data' => $jobs
            ], 200);
        }

        foreach ($jobs as $job) {
            $quotation = Quotation::where('jobId', $job->id)->first();

            if ($quotation == "") {
                $job->quotation = "Quotation has not been created";
            } else {
                $job->quotation = [
                    'quotationDetails' => $quotation,
                    'items' => [
                        'totalNumber' => Item::where('jobId', $job->id)->count(),
                        'totalAmount' => Item::where('jobId', $job->id)->get('totalPrice')->sum('totalPrice'),
                        'itemList' => Item::where('jobId', $job->id)->get(),
                    ],

                    'tax' => [
                        'totalAmount' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->get('amount')->sum('amount'),
                        'totalNumber' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->count(),
                        'taxList' => Payment::where('jobId', $job->id)->where('paymentType', 'tax')->get()
                    ],
                    'discount' => [
                        'totalAmount' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->get('amount')->sum('amount'),
                        'totalNumber' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->count(),
                        'discountList' => Payment::where('jobId', $job->id)->where('paymentType', 'discount')->get()
                    ]
                ];
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Quotation has been updated successfully',
            'data' => $jobs
        ], 200);
    }

    // function to get report
    public function getReport(Request $request)
    {
        $report = [];
        $report['totalIncome'] = Job::where('jobs.userId', $request->userID)->where('jobs.status', 'completed')
            ->join('quotations', 'quotations.jobId', '=', 'jobs.id')
            ->sum('quotations.profit');
        $report['data'] = Job::where('jobs.userId', $request->userID)->where('jobs.status', 'completed')
            ->join('quotations', 'quotations.jobId', '=', 'jobs.id')
            ->selectRaw('month(jobs.created_at) as month')
            ->selectRaw('year(jobs.created_at) as year')
            ->selectRaw('count(jobs.id) as numOfJobs')
            ->selectRaw('sum(quotations.profit) as income')
            ->groupBy('month', 'year')
            ->latest('jobs.created_at')
            ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Report has been fetched',
            'data' => $report
        ], 200);
    }

    // function to download quotation/invoice
    public function downloadQuotation(Request $request)
    {   
        $pdf = PDF::loadView('quotationtemplate1');
        
        // download PDF file with download method
        return $pdf->download('Quotation.pdf');
    }
}
