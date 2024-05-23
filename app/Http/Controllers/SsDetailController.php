<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSsDetailRequest;
use App\Http\Requests\UpdateSsDetailRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\SsDetailRepository;
use Illuminate\Http\Request;
use Flash;

class SsDetailController extends AppBaseController
{
    /** @var SsDetailRepository $ssDetailRepository*/
    private $ssDetailRepository;

    public function __construct(SsDetailRepository $ssDetailRepo)
    {
        $this->ssDetailRepository = $ssDetailRepo;
    }

    /**
     * Display a listing of the SsDetail.
     */
    public function index(Request $request)
    {
        $ssDetails = $this->ssDetailRepository->paginate(10);

        return view('ss_details.index')
            ->with('ssDetails', $ssDetails);
    }

    /**
     * Show the form for creating a new SsDetail.
     */
    public function create()
    {
        return view('ss_details.create');
    }

    /**
     * Store a newly created SsDetail in storage.
     */
    public function store(CreateSsDetailRequest $request)
    {
        $input = $request->all();

        $ssDetail = $this->ssDetailRepository->create($input);

        Flash::success('Ss Detail saved successfully.');

        return redirect(route('ssDetails.index'));
    }

    /**
     * Display the specified SsDetail.
     */
    public function show($id)
    {
        $ssDetail = $this->ssDetailRepository->find($id);

        if (empty($ssDetail)) {
            Flash::error('Ss Detail not found');

            return redirect(route('ssDetails.index'));
        }

        return view('ss_details.show')->with('ssDetail', $ssDetail);
    }

    /**
     * Show the form for editing the specified SsDetail.
     */
    public function edit($id)
    {
        $ssDetail = $this->ssDetailRepository->find($id);

        if (empty($ssDetail)) {
            Flash::error('Ss Detail not found');

            return redirect(route('ssDetails.index'));
        }

        return view('ss_details.edit')->with('ssDetail', $ssDetail);
    }

    /**
     * Update the specified SsDetail in storage.
     */
    public function update($id, UpdateSsDetailRequest $request)
    {
        $ssDetail = $this->ssDetailRepository->find($id);

        if (empty($ssDetail)) {
            Flash::error('Ss Detail not found');

            return redirect(route('ssDetails.index'));
        }

        $ssDetail = $this->ssDetailRepository->update($request->all(), $id);

        Flash::success('Ss Detail updated successfully.');

        return redirect(route('ssDetails.index'));
    }

    /**
     * Remove the specified SsDetail from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $ssDetail = $this->ssDetailRepository->find($id);

        if (empty($ssDetail)) {
            Flash::error('Ss Detail not found');

            return redirect(route('ssDetails.index'));
        }

        $this->ssDetailRepository->delete($id);

        Flash::success('Ss Detail deleted successfully.');

        return redirect(route('ssDetails.index'));
    }
}
