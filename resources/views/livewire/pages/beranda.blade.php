<div>
    <div class="container mt-4">
        <h5 class="mb-3">Grafik Jumlah Test Cases Berdasarkan Progress</h5>
        <canvas id="testCasesChart"></canvas>
    </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chartData); // Data dari backend

        // Pisahkan data label dan total untuk digunakan di Chart.js
        const labels = chartData.map(item => item.label);
        const data = chartData.map(item => item.progress);

        const ctx = document.getElementById('testCasesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Label setiap status
                datasets: [{
                    label: 'Jumlah TestCase per Progress',
                    data: data, // Jumlah test result per status
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',  // Warna merah
                        'rgba(54, 162, 235, 0.6)',  // Warna biru
                        'rgba(255, 206, 86, 0.6)',  // Warna kuning
                        'rgba(75, 192, 192, 0.6)',  // Warna hijau
                        'rgba(153, 102, 255, 0.6)', // Warna ungu
                        'rgba(255, 159, 64, 0.6)'   // Warna oranye
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',  // Warna merah
                        'rgba(54, 162, 235, 1)',  // Warna biru
                        'rgba(255, 206, 86, 1)',  // Warna kuning
                        'rgba(75, 192, 192, 1)',  // Warna hijau
                        'rgba(153, 102, 255, 1)', // Warna ungu
                        'rgba(255, 159, 64, 1)'   // Warna oranye
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>