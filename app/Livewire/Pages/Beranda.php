<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\TestCase;
use App\Models\TestSuite;
use App\Models\TestResult;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

// Menentukan layout untuk komponen ini menggunakan Livewire
#[Layout('components.layouts.app')]
class Beranda extends Component
{
    use WithPagination; // Menggunakan trait untuk menambahkan dukungan pagination
    protected $paginationTheme = 'bootstrap';

    public function getChartData()
    {
        // Mengambil semua test cases dan menghitung progress total
        $testCases = TestCase::all();

        // Menyiapkan data dalam bentuk array label dan progress
        $chartData = $testCases->map(function ($testCase) {
            return [
                'label' => $testCase->kode.'(Test Suite ' . $testCase->test_suite_id . ')',
                'progress' => $testCase->progress, // Mengambil progress dari setiap test case
            ];
        })->toArray(); // Pastikan data dikembalikan sebagai array

        return $chartData;
    }

    public function render()
    {
        // Mengambil hasil test dengan relasi userPenugasan dan status, kemudian mempaginate hasilnya
        $testResults = TestResult::with(['userPenugasan', 'status'])
            ->paginate(5, ['*'], 'testResultsPage'); // Paginate dengan namespace 'testResultsPage'

        // Mengambil test case dengan relasi testSuite dan testResults, kemudian mempaginate hasilnya
        $testCases = TestCase::with('testSuite', 'testResults')
            ->paginate(5, ['*'], 'testCasesPage'); // Paginate dengan namespace 'testCasesPage'

        // Mengambil test suite dengan relasi project, kemudian mempaginate hasilnya
        $testSuites = TestSuite::with('project')
            ->paginate(5, ['*'], 'testSuitesPage'); // Paginate dengan namespace 'testSuitesPage'
        
        $chartData = $this->getChartData(); // Panggil metode getChartData

        // Mengembalikan view dengan data hasil query
        return view('livewire.pages.beranda', [
            'testResults' => $testResults,
            'testCases' => $testCases,
            'testSuites' => $testSuites,
            'chartData' => $chartData, // Tambahkan ini
        ]);
    }
}
