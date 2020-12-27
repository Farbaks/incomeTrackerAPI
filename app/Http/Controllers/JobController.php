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
            'jobName' => 'required|max:255',
            'companyName' => 'required|max:255',
            'companyAddress' => 'required',
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
        $job->jobName = $request->jobName;
        $job->companyName = $request->companyName;
        $job->companyAddress = $request->companyAddress;
        $job->contactName = $request->contactName;
        $job->contactNumber = $request->contactNumber;
        $job->status = "Pending Quotation Creation";
        $job->comment = "";
        if ($request->comment) {
            $job->comment = $request->comment;
        }
        $job->userId = $request->userID;

        $job->save();
        $checkQuotation = Quotation::where('jobId', $job->id)->first();

        if ($checkQuotation == "") {
            $job->quotation = "Quotation has not been created";
        } else {
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
        }

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
            'id' => 'required|numeric',
            'jobName' => 'required|max:255',
            'companyName' => 'required|max:255',
            'companyAddress' => 'required',
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

        $job = Job::find($request->id);

        if ($job == "") {
            return response()->json([
                'status' => 400,
                'message' => 'Job does not exist',
                'data' => $job
            ], 400);
        }
        $job->update([
            'jobName' => $request->jobName,
            'companyName' => $request->companyName,
            'companyAddress' => $request->companyAddress,
            'contactName' => $request->contactName,
            'contactNumber' => $request->contactNumber,
        ]);
        if ($request->comment) {
            $job->update([
                'comment' => $request->comment
            ]);
        }

        $checkQuotation = Quotation::where('jobId', $job->id)->first();

        if ($checkQuotation == "") {
            $job->quotation = "Quotation has not been created";
        } else {
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
        }

        return response()->json([
            'status' => 200,
            'message' => 'Job has been updated successfully',
            'data' => $job
        ], 200);
    }

    //funciton to delete a job
    public function deleteJob($id)
    {
        $job = Job::find($id);

        if ($job == "") {
            return response()->json([
                'status' => 400,
                'message' => 'Job does not exist',
                'data' => $job
            ], 400);
        }
        $job->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Job has been deleted successfully',
            'data' => []
        ], 200);
    }

    //funciton to edit a job status
    public function editJobStatus(Request $request)
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
        } else {
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
        }
        return response()->json([
            'status' => 200,
            'message' => 'Job status has been updated successfully',
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
            'subTotalJobCost' => 'required',
            'totalJobCost' => 'required',
            'profit' => 'required',
            'jobId' => 'required|numeric',
            'items' => 'required',
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
                'message' => 'Quotation has already been created',
                'data' => []
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
        $quotation->currency = User::find($request->userID)->currency;
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
        if ($request->payments) {
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
            'subTotalJobCost' => 'required',
            'totalJobCost' => 'required',
            'profit' => 'required',
            'jobId' => 'required|numeric',
            'items' => 'required',
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
            return response()->json([
                'status' => 400,
                'message' => 'Quotation has not been created',
                'data' => []
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

        if ($request->payments) {
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
    public function getJob(Request $request, $id)
    {
        $job = Job::find($id);

        if ($job == "") {
            return response()->json([
                'status' => 400,
                'message' => 'Job does not exist',
                'data' => $job
            ], 400);
        }
        $job->currency = User::find($request->userID)->currency;
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

        return response()->json([
            'status' => 200,
            'message' => 'Job has been fetched successfully',
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
        $jobCount = Job::where('userId', $request->userID)->latest()
            ->count();

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
            $job->currency = User::find($request->userID)->currency;
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
            'message' => 'Jobs have been fetched successfully',
            "totalJobCount" => $jobCount,
            "offset" => $request->offset,
            "limit" => $request->limit,
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
        $check = Job::where('jobs.userId', $request->userID)->where('jobs.status', 'completed')
            ->join('quotations', 'quotations.jobId', '=', 'jobs.id')
            ->select('quotations.currency')->first();
        $report['currency'] = null;
        if ($check != "") {
            $report['currency'] = User::find($request->userID)->currency;
        }
        $report['report'] = Job::where('jobs.userId', $request->userID)->where('jobs.status', 'completed')
            ->join('quotations', 'quotations.jobId', '=', 'jobs.id')
            ->selectRaw('extract(month from jobs.created_at) as month')
            ->selectRaw('extract(year from jobs.created_at) as year')
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
    // function to view quotation
    public function viewQuotation(Request $request, $jobId, $type)
    {

        $job = Job::find($jobId);
        if ($job == '') {
            return response()->json([
                'status' => 400,
                'message' => 'This job does not exist',
                'data' => []
            ], 400);
        }

        $user = User::find($job->userId);

        $q = Quotation::where('jobId', $jobId)->first();

        if ($q == "") {
            return response()->json([
                'status' => 200,
                'message' => 'Quotation not be found',
            ], 200);
        }
        $job->currency = User::find($request->userID)->currency;
        $job->quotation = [
            'quotationDetails' => $q,
            'items' => [
                'totalNumber' => Item::where('jobId', $jobId)->count(),
                'totalAmount' => Item::where('jobId', $jobId)->get('totalPrice')->sum('totalPrice'),
                'itemList' => Item::where('jobId', $jobId)->get(),
            ],

            'tax' => [
                'totalAmount' => Payment::where('jobId', $jobId)->where('paymentType', 'tax')->get('amount')->sum('amount'),
                'totalNumber' => Payment::where('jobId', $jobId)->where('paymentType', 'tax')->count(),
                'taxList' => Payment::where('jobId', $jobId)->where('paymentType', 'tax')->get()
            ],
            'discount' => [
                'totalAmount' => Payment::where('jobId', $jobId)->where('paymentType', 'discount')->get('amount')->sum('amount'),
                'totalNumber' => Payment::where('jobId', $jobId)->where('paymentType', 'discount')->count(),
                'discountList' => Payment::where('jobId', $jobId)->where('paymentType', 'discount')->get()
            ]
        ];
        return view('quotationtemplate1', ['type' => $type, 'job' => $job, 'user' => $user]);
    }
}
