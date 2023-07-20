<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class DepartmentController extends AppBaseController
{
    /** @var DepartmentRepository */
    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * Display a listing of the Department.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('departments.index');
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param  CreateDepartmentRequest  $request
     *
     * @return Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $input = $request->all();

        $department = $this->departmentRepository->create($input);

        activity()->performedOn($department)->causedBy(getLoggedInUser())
            ->useLog('New Department created.')->log($department->name.' Department created.');

        return $this->sendResponse($department, 'Department saved successfully.');
    }

    /**
     * Show the form for editing the specified Department.
     *
     * @param  Department  $department
     *
     * @return Response
     */
    public function edit(Department $department)
    {
        return $this->sendResponse($department, 'Department retrieved successfully.');
    }

    /**
     * Update the specified Department in storage.
     *
     * @param  Department  $department
     *
     * @param  UpdateDepartmentRequest  $request
     *
     * @return Response
     */
    public function update(Department $department, UpdateDepartmentRequest $request)
    {
        $input = $request->all();

        $department = $this->departmentRepository->update($input, $department->id);

        activity()->performedOn($department)->causedBy(getLoggedInUser())
            ->useLog('Department updated.')->log($department->name.' Department updated.');

        return $this->sendSuccess('Department updated successfully.');
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  Department  $department
     *
     * @throws Exception
     *
     * @return Response
     */
    public function destroy(Department $department)
    {
        activity()->performedOn($department)->causedBy(getLoggedInUser())
            ->useLog('Department deleted.')->log($department->name.' Department deleted.');

        $department->delete();

        return $this->sendSuccess('Department deleted successfully.');
    }
}
