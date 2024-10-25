<div>
    <!-- Hasil Test Saya Table -->
    <div class="container mt-4">
        <h5 class="mb-3">Hasil Test Saya</h5>
        <div class="bg-white p-4 rounded shadow-sm">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Harapan</th>
                            <th>Realisasi</th>
                            <th>Penugasan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testResults as $test_result)
                            <tr onclick="window.location='{{ route('testresult.index', [
                                $test_result->testCase->testSuite->project->id ?? '#',
                                $test_result->testCase->testSuite->id ?? '#',
                                $test_result->testCase->id ?? '#',
                                $test_result->id
                            ]) }}'" style="cursor: pointer;">
                                <td>{{ $test_result->kode }}</td>
                                <td>{{ $test_result->harapan }}</td>
                                <td>{{ $test_result->realisasi }}</td>
                                <td>{{ $test_result->userPenugasan->name }}</td>
                                <td>{{ $test_result->status->label }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $testResults->links() }}
        </div>
    </div>

    <!-- Test Case Saya Table -->
    <div class="container mt-4">
        <h5 class="mb-3">Test Case Saya</h5>
        <div class="bg-white p-4 rounded shadow-sm">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Judul Test Case</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testCases as $test_case)
                            <tr onclick="window.location='{{ route('testcase.index', [
                                $test_case->testSuite->project->id ?? '#',
                                $test_case->testSuite->id ?? '#',
                                $test_case->id
                            ]) }}'" style="cursor: pointer;">
                                <td>{{ $test_case->kode }}</td>
                                <td>{{ $test_case->judul }}</td>
                                <td>
                                    @if ($test_case->progress == 100)
                                        <i class="fa-solid fa-circle me-2 text-secondary"></i>
                                        {{ $test_case->progress }}%
                                    @elseif($test_case->progress >= 50)
                                        <i class="fa-solid fa-circle-half-stroke me-2 text-secondary"></i>
                                        {{ $test_case->progress }}%
                                    @else
                                        <i class="fa-regular fa-circle me-2 text-secondary"></i>
                                        {{ $test_case->progress }}%
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $testCases->links() }}
        </div>
    </div>

    <!-- Test Suite Saya Table -->
    <div class="container mt-4">
        <h5 class="mb-3">Test Suite Saya</h5>
        <div class="bg-white p-4 rounded shadow-sm">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Project</th>
                            <th>Judul Test Suite</th>
                            <th>Jumlah Test Case</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testSuites as $suite)
                            <tr onclick="window.location='{{ route('testsuite.index', [
                                $suite->project->id ?? '#',
                                $suite->id
                            ]) }}'" style="cursor: pointer;">   
                                <td>{{ $suite->kode }}</td>
                                <td>{{ $suite->project ? $suite->project->nama : '-' }}</td>
                                <td>{{ $suite->judul }}</td>
                                <td>{{ $suite->testCases->count() }}</td>
                                <td>
                                    @if ($suite->progress == 100)
                                        <i class="fa-solid fa-circle me-2 text-secondary"></i> {{ $suite->progress }}%
                                    @elseif($suite->progress >= 50)
                                        <i class="fa-solid fa-circle-half-stroke me-2 text-secondary"></i>
                                        {{ $suite->progress }}%
                                    @else
                                        <i class="fa-regular fa-circle me-2 text-secondary"></i>
                                        {{ $suite->progress }}%
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $testSuites->links() }}
        </div>
    </div>
</div>
