<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BorrowRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BorrowingTrackingController extends Controller
{
    /**
     * Display the borrowing lookup form.
     */
    public function index(Request $request)
    {
        $employeeId = $request->query('employee_id');
        
        if (!$employeeId) {
            return Inertia::render('asset-portal/my-borrowings-lookup');
        }

        return $this->show($employeeId);
    }

    /**
     * Display borrowings for a specific employee.
     */
    public function show(string $employeeId)
    {
        $borrowRequests = BorrowRequest::with(['asset.category', 'processedBy'])
            ->where('borrower_employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('asset-portal/my-borrowings', [
            'borrowRequests' => $borrowRequests,
            'employeeId' => $employeeId,
        ]);
    }
}