<?php 
// Ensure we have a valid stat item
$stat = $stat ?? [
    'title' => 'Default Title',
    'value' => '0',
    'icon' => 'user',
    'color' => 'gray',
    'bgClass' => 'modern-btn',
];
?>
<div class="flex items-center p-4 <?= htmlspecialchars($stat['bgClass']) ?> rounded-lg shadow-xs ">
    <div class="p-3 w-12 h-12 flex items-center justify-center mr-4 text-<?= htmlspecialchars($stat['color']) ?>-500 bg-<?= htmlspecialchars($stat['color']) ?>-100 rounded-full">
        <i class="fas fa-<?= htmlspecialchars($stat['icon']) ?> text-lg"></i>
    </div>
    <div>
        <p class="mb-2 text-sm font-medium text-white">
            <?= htmlspecialchars($stat['title']) ?>
        </p>
        <p class="text-lg font-semibold text-white">
                    <?= htmlspecialchars($stat['value']) ?>
                  </p>
                </div>
              </div>