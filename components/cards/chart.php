<?php
$response = $GLOBALS['response'] ?? [];

// Initialize counts
$statusCounts = [
    'Pending' => 0,
    'Quoted' => 0,
    'Assigned' => 0,
    'In Process' => 0,
    'Completed' => 0,
    'Cancelled' => 0,
    'Vendor Pending' => 0,
    'Vendor Accepted' => 0,
    'Vendor Rejected' => 0
];

// Count statuses
foreach ($response as $item) {
    $status = strtolower($item['status_c'] ?? '');
    $vendorStatus = $item['vendor_status_c'] ?? '';
    
    if (in_array($status, ['', 'pending', 'inprocess'])) $statusCounts['Pending']++;
    elseif ($status === 'quoted') $statusCounts['Quoted']++;
    elseif ($status === 'assigned') $statusCounts['Assigned']++;
    elseif ($status === 'converted') $statusCounts['Completed']++;
    elseif ($status === 'deleted') $statusCounts['Cancelled']++;
    elseif ($status === 'dead') $statusCounts['Cancelled']++;
    
    if ($vendorStatus === '0') $statusCounts['Vendor Pending']++;
    elseif ($vendorStatus === '1') $statusCounts['Vendor Accepted']++;
    elseif ($vendorStatus === '-1') $statusCounts['Vendor Rejected']++;
}
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Shipment Status Chart -->
    <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800 dark:text-white">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 dark:text-white">Shipment Status</h2>
        <div id="statusChart"></div>
    </div>
    
    <!-- Vendor Status Chart -->
    <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800 dark:text-white">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 dark:text-white">Booking Status</h2>
        <div id="vendorChart"></div>
    </div>
</div>

<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Convert PHP array to JSON for JavaScript
    const statusData = <?= json_encode([
        // 'Pending' => $statusCounts['Pending'],
        'Quoted' => $statusCounts['Quoted'],
        'Assigned' => $statusCounts['Assigned'],
        'Completed' => $statusCounts['Completed'],
        'Cancelled' => $statusCounts['Cancelled']
    ]) ?>;

    const vendorData = <?= json_encode([
        'Pending' => $statusCounts['Vendor Pending'],
        'Accepted' => $statusCounts['Vendor Accepted'],
        'Rejected' => $statusCounts['Vendor Rejected']
    ]) ?>;

    // Shipment Status Chart
    const statusOptions = {
        series: [{
            name: 'Shipments',
            data: Object.values(statusData)
        }],
        chart: { 
            type: 'bar', 
            height: 350,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: true
                }
            }
        },
        colors: ['#3B82F6'],
        plotOptions: { 
            bar: { 
                columnWidth: '60%', 
                borderRadius: 4,
                dataLabels: {
                    position: 'top'
                }
            } 
        },
        dataLabels: { 
            enabled: true,
            offsetY: -20,
            style: {
                fontSize: '10px',
                colors: ['#fff']
            }
        },
        xaxis: {
            categories: Object.keys(statusData),
            labels: { 
                style: { 
                    fontSize: '12px',
                    fontFamily: 'Inter, sans-serif',
                    color: '#fff'
                } 
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: { 
            title: { 
                text: 'Number of Shipments',
                style: {
                    fontSize: '12px',
                    fontFamily: 'Inter, sans-serif',
                    color: '#fff'
                }
            },
            labels: {
                style: {
                    fontSize: '12px',
                    fontFamily: 'Inter, sans-serif',
                    color: '#fff'
                }
            },
            min: 0,
            tickAmount: 5
        },
        tooltip: { 
            y: { 
                formatter: function(val) { 
                    return val + (val === 1 ? ' shipment' : ' shipments'); 
                } 
            } 
        },
        grid: {
            borderColor: '#fff',
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        
    };

    // Vendor Status Chart
    const vendorOptions = {
        series: Object.values(vendorData),
        chart: { 
            type: 'donut', 
            height: 350,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: true
                }
            }
        },
        labels: Object.keys(vendorData),
        colors: ['#F59E0B', '#10B981', '#EF4444'],
        legend: { 
            position: 'bottom',
            fontFamily: 'Inter, sans-serif',
            fontSize: '14px',
            labels: {
                colors: '#4B5563',
                useSeriesColors: false
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: { 
                            show: true, 
                            label: 'Total',
                            color: '#6B7280',
                            fontFamily: 'Inter, sans-serif',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '12px',
                fontFamily: 'Inter, sans-serif',
                fontWeight: '600'
            },
            dropShadow: {
                enabled: false
            }
        },
        tooltip: { 
            y: { 
                formatter: function(val) { 
                    return val + (val === 1 ? ' shipment' : ' shipments'); 
                } 
            },
            style: {
                fontFamily: 'Inter, sans-serif'
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    height: 300
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    // Initialize charts
    const statusChart = new ApexCharts(document.querySelector("#statusChart"), statusOptions);
    statusChart.render();

    const vendorChart = new ApexCharts(document.querySelector("#vendorChart"), vendorOptions);
    vendorChart.render();
});
</script>