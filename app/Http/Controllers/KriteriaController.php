<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\ExpertKriteriaComparison;
use App\ExpertSubComparison;
use App\FuzzyKriteria;
use App\FuzzySub;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateKriteriaRequest;
use App\Http\Requests\UpdateKriteriaRequest;
use App\Models\KriteriaKriteria;
use App\Models\PemasokSub;
use App\Models\SubKriteria;
use App\Models\SubKriteriaSubKriteria;
use App\PemasokSubFuzzyResult;
use App\PemasokSubResult;
use App\Repositories\KriteriaRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class KriteriaController extends AppBaseController
{
    public function __construct(
        private readonly KriteriaRepository $kriteriaRepository
    ) {
    }

    public function index(Request $request): View
    {
        $this->kriteriaRepository->pushCriteria(new RequestCriteria($request));
        $kriterias = $this->kriteriaRepository->all();

        return view('kriterias.index', compact('kriterias'));
    }

    public function create(): View
    {
        return view('kriterias.create');
    }

    public function store(CreateKriteriaRequest $request): RedirectResponse
    {
        $this->kriteriaRepository->create($request->validated());

        return redirect()
            ->route('kriterias.index')
            ->with('success', 'Kriteria saved successfully.');
    }

    public function show(int $id): View|RedirectResponse
    {
        $kriteria = $this->kriteriaRepository->findWithoutFail($id);

        if (empty($kriteria)) {
            return redirect()
                ->route('kriterias.index')
                ->with('error', 'Kriteria not found');
        }

        return view('kriterias.show', compact('kriteria'));
    }

    public function edit(int $id): View|RedirectResponse
    {
        $kriteria = $this->kriteriaRepository->findWithoutFail($id);

        if (empty($kriteria)) {
            return redirect()
                ->route('kriterias.index')
                ->with('error', 'Kriteria not found');
        }

        return view('kriterias.edit', compact('kriteria'));
    }

    public function update(int $id, UpdateKriteriaRequest $request): RedirectResponse
    {
        $kriteria = $this->kriteriaRepository->findWithoutFail($id);

        if (empty($kriteria)) {
            return redirect()
                ->route('kriterias.index')
                ->with('error', 'Kriteria not found');
        }

        $this->kriteriaRepository->update($request->validated(), $id);

        return redirect()
            ->route('kriterias.index')
            ->with('success', 'Kriteria updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $kriteria = $this->kriteriaRepository->findWithoutFail($id);

        if (empty($kriteria)) {
            return redirect()
                ->route('kriterias.index')
                ->with('error', 'Kriteria not found');
        }

        // Delete related kriteria comparisons
        KriteriaKriteria::where('kriteria1_id', $id)->delete();
        KriteriaKriteria::where('kriteria2_id', $id)->delete();

        // Delete related sub-kriteria comparisons
        $subKriterias = SubKriteria::where('kriteria_id', $id)->get();
        foreach ($subKriterias as $sub) {
            SubKriteriaSubKriteria::where('sub_kriteria1_id', $sub->id)->delete();
            SubKriteriaSubKriteria::where('sub_kriteria2_id', $sub->id)->delete();
        }

        // Delete sub-kriterias and related data
        SubKriteria::where('kriteria_id', $id)->delete();
        PemasokSub::where('kriteria_id', $id)->delete();

        // Clear comparison results (consider moving to service layer)
        ExpertKriteriaComparison::query()->delete();
        ExpertSubComparison::query()->delete();
        FuzzyKriteria::query()->delete();
        FuzzySub::query()->delete();
        PemasokSubFuzzyResult::query()->delete();
        PemasokSubResult::query()->delete();

        $this->kriteriaRepository->delete($id);

        return redirect()
            ->route('kriterias.index')
            ->with('success', 'Kriteria deleted successfully.');
    }
}
