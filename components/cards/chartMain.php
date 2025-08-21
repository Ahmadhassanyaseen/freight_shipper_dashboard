<?php
$response = $GLOBALS['response'] ?? [];

// Process the data to get counts by status for the last 7 days
$today = new DateTime();
$dates = [];
$statusCounts = [
    'Pending' => [],
    'Completed' => [],
    'Cancelled' => []
];

// Initialize date range (last 7 days)
for ($i = 30; $i >= 0; $i--) {
    $date = clone $today;
    $date->modify("-$i days");
    $dateStr = $date->format('m/d/Y');
    $dates[] = $dateStr;
    
    // Initialize counts for each status
    foreach ($statusCounts as $status => $counts) {
        $statusCounts[$status][$dateStr] = 0;
    }
}

// Count statuses by date
foreach ($response as $item) {
    $itemDate = new DateTime($item['date_entered'] ?? 'now');
    $itemDateStr = $itemDate->format('m/d/Y');
    $status = strtolower($item['status_c'] ?? '');
    // print_r($status);
    echo "  ";
    
    if (in_array($itemDateStr, $dates)) {
        if (in_array($status, ['quoted', 'pending', 'assigned'])) {
            $statusCounts['Pending'][$itemDateStr]++;
        } elseif ($status === 'converted') {
            $statusCounts['Completed'][$itemDateStr]++;
        } elseif (in_array($status, ['deleted', 'cancelled'])) {
            $statusCounts['Cancelled'][$itemDateStr]++;
        } else {
            // Default to Pending for any other status
            $statusCounts['Pending'][$itemDateStr]++;
        }
    }
}
?>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">System Wide Load Count</h2>
        <!-- <div class="flex space-x-2">
            <button class="prev-arrow px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            <button class="next-arrow px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
        </div> -->
    </div>
    <div id="statusChartMain"></div>
</div>
<?php
// print_r($statusCounts);
?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var dates = <?= json_encode($dates) ?>;
    var statusData = <?= json_encode(array_values($statusCounts)) ?>;
    
    var options = {
        series: [{
            name: 'Available',
            type: 'column',
            data: Object.values(statusData[0])
        }, {
            name: 'Booked',
            type: 'area',
            data: Object.values(statusData[1])
        }, {
            name: 'Cancelled',
            type: 'line',
            data: Object.values(statusData[2])
        }],
        // chart: {
        //     height: 350,
        //     type: 'line',
        //     stacked: false,
        //     toolbar: {
        //         show: true,
        //         tools: {
        //             download: true,
        //             selection: false,
        //             zoom: false,
        //             zoomin: false,
        //             zoomout: false,
        //             pan: false,
        //             reset: true
        //         }
        //     }
        // },
        chart: {
          height: 350,
          type: 'line',
          stacked: false,
        },
        stroke: {
            width: [0, 2, 5],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '50%',
                borderRadius: 4
            }
        },
        fill: {
            opacity: [0.85, 0.25, 1],
            gradient: {
                inverseColors: false,
                shade: 'light',
                type: "vertical",
                opacityFrom: 0.85,
                opacityTo: 0.55,
                stops: [0, 100, 100, 100]
            }
        },
        labels: dates,
        markers: {
            size: 0
        },
        xaxis: {
            type: 'datetime',
            labels: {
                datetimeUTC: false,
                format: 'MM/dd/yyyy'
            }
        },
        yaxis: {
            title: {
                text: 'Number of Loads',
            },
            min: 0,
            forceNiceScale: true,
            tickAmount: 5
        },
        tooltip: {
            shared: true,
            intersect: false,
            x: {
                format: 'MM/dd/yyyy'
            },
            y: {
                formatter: function (y) {
                    if (typeof y !== "undefined") {
                        return y + (y === 1 ? ' load' : ' loads');
                    }
                    return y;
                }
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            // offsetY: -5
        },
        colors: ['#3B82F6', '#10B981', '#EF4444'],
        // navigation: {
        //     enabled: true,
        //     position: 'top-right',
        //     buttons: {
        //         next: {
        //             text: 'Next',
        //             class: 'next-arrow',
        //             offsetX: -10,
        //             offsetY: 0
        //         },
        //         prev: {
        //             text: 'Prev',
        //             class: 'prev-arrow',
        //             offsetX: 10,
        //             offsetY: 0
        //         }
        //     }
        // },
        events: {
            beforeZoom: function(chartContext, { xaxis }) {
                // Store the current zoom level
                chartContext.w.globals.zoomed = true;
            },
            beforeResetZoom: function(chartContext) {
                // Reset zoom flag
                chartContext.w.globals.zoomed = false;
            }
        },
        toolbar: {
            show: true,
            offsetX: 0,
            offsetY: 0,
            tools: {
                download: true,
                selection: true,
                zoom: true,
                zoomin: true,
                zoomout: true,
                pan: true,
                reset: true
            },
            autoSelected: 'zoom'
        }
    };

    var chart = new ApexCharts(document.querySelector("#statusChartMain"), options);
    
    // Store the current date range
    var currentStartDate = new Date();
    currentStartDate.setDate(currentStartDate.getDate() - 6); // Default to last 7 days
    
    // Add loading state class to chart container
    const chartContainer = document.querySelector("#statusChartMain");
    
    // Initialize the chart
    chart.render().then(() => {
        // Enable navigation after initial render
        // setupNavigation();
    });
    
    function showLoading() {
        chartContainer.classList.add('opacity-50', 'pointer-events-none');
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'absolute inset-0 flex items-center justify-center';
        loadingIndicator.innerHTML = `
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
        `;
        loadingIndicator.id = 'chart-loading';
        chartContainer.parentNode.style.position = 'relative';
        chartContainer.parentNode.appendChild(loadingIndicator);
    }
    
    function hideLoading() {
        chartContainer.classList.remove('opacity-50', 'pointer-events-none');
        const loadingIndicator = document.getElementById('chart-loading');
        if (loadingIndicator) {
            loadingIndicator.remove();
        }
    }
    
    // function setupNavigation() {
    //     // Add navigation functionality
    //     document.querySelector('.prev-arrow')?.addEventListener('click', function() {
    //         // Move back one week
    //         currentStartDate.setDate(currentStartDate.getDate() - 7);
    //         updateChartForWeek(currentStartDate);
    //     });

    //     document.querySelector('.next-arrow')?.addEventListener('click', function() {
    //         // Move forward one week
    //         var nextStartDate = new Date(currentStartDate);
    //         nextStartDate.setDate(nextStartDate.getDate() + 7);
            
    //         // Don't allow navigating to future dates
    //         var today = new Date();
    //         if (nextStartDate < today) {
    //             currentStartDate = nextStartDate;
    //             updateChartForWeek(currentStartDate);
    //         }
    //     });
        
    //     // Disable next button if we're at the current week
    //     updateNavigationButtons();
    // }
    
    // function updateNavigationButtons() {
    //     const nextButton = document.querySelector('.next-arrow');
    //     if (nextButton) {
    //         const today = new Date();
    //         const nextWeek = new Date(currentStartDate);
    //         nextWeek.setDate(nextWeek.getDate() + 7);
    //         nextButton.disabled = nextWeek >= today;
    //     }
    // }

    // function updateChartForWeek(startDate) {
    //     // Disable buttons during update
    //     document.querySelectorAll('.prev-arrow, .next-arrow').forEach(btn => {
    //         btn.disabled = true;
    //     });
        
    //     // Show loading state
    //     showLoading();
        
    //     // Process data without timeout for immediate update
    //     try {
    //         // Generate new dates for the selected week
    //         var newDates = [];
    //         var newData = {
    //             'Pending': [],
    //             'Completed': [],
    //             'Cancelled': []
    //         };
            
    //         // Process data for the selected week
    //         for (var i = 0; i < 7; i++) {
    //             var currentDate = new Date(startDate);
    //             currentDate.setDate(startDate.getDate() + i);
    //             var dateStr = currentDate.toLocaleDateString('en-US', {month: '2-digit', day: '2-digit', year: 'numeric'});
    //             newDates.push(dateStr);
                
    //             // Count statuses for each day
    //             var dayCounts = {
    //                 'Pending': 0,
    //                 'Completed': 0,
    //                 'Cancelled': 0
    //             };
                
    //             // Filter and count data for this date
                // var responseData = 
    //             responseData.forEach(function(item) {
    //                 var itemDate = new Date(item.date_entered || new Date());
    //                 var itemDateStr = itemDate.toLocaleDateString('en-US', {month: '2-digit', day: '2-digit', year: 'numeric'});
    //                 var status = (item.status_c || '').toLowerCase();
                    
    //                 if (itemDateStr === dateStr) {
    //                     if (['quoted', 'pending', 'assigned'].includes(status)) {
    //                         dayCounts['Pending']++;
    //                     } else if (status === 'converted') {
    //                         dayCounts['Completed']++;
    //                     } else if (['deleted', 'cancelled'].includes(status)) {
    //                         dayCounts['Cancelled']++;
    //                     } else {
    //                         dayCounts['Pending']++;
    //                     }
    //                 }
    //             });
                
    //             // Add counts to the data series
    //             newData['Pending'].push(dayCounts['Pending']);
    //             newData['Completed'].push(dayCounts['Completed']);
    //             newData['Cancelled'].push(dayCounts['Cancelled']);
    //         }
            
    //         // Update chart with new data
    //         chart.updateOptions({
    //             xaxis: {
    //                 categories: newDates
    //             }
    //         });
            
    //         chart.updateSeries([
    //             { name: 'Pending', data: newData['Pending'] },
    //             { name: 'Completed', data: newData['Completed'] },
    //             { name: 'Cancelled', data: newData['Cancelled'] }
    //         ]);
            
    //         // Update navigation buttons
    //         updateNavigationButtons();
            
    //         // Re-enable buttons
    //         document.querySelectorAll('.prev-arrow, .next-arrow').forEach(btn => {
    //             btn.disabled = false;
    //         });
            
    //     } catch (error) {
    //         console.error('Error updating chart:', error);
    //     } finally {
    //         // Always hide loading state
    //         hideLoading();
    //     }
    // }
});
</script>