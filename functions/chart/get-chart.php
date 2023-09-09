<?php

function current_chart($type = 'line'){
    global $db;
    $sql = "SELECT DATE(t.created_at) AS date,
            SUM(CASE
                WHEN r.type = 'day' THEN co.priceDay
                WHEN r.type = 'night' THEN co.priceNight
                ELSE 0 
            END) AS total_sales
            FROM transactions t
            JOIN rentals r ON t.id = r.transact_id
            JOIN cottages co ON r.cottage_id = co.id
            WHERE t.status = 'Proceed' 
            AND DATE(t.created_at) = CURDATE()  
            GROUP BY DATE(t.created_at)
            ORDER BY DATE(t.created_at);";
        
    $stmt = $db->prepare($sql);
    $stmt->execute();
        
    $labels = [];
    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $labels[] = date("D m", strtotime($row['date']));
        $data[] = $row['total_sales'];
    }
    $chartData = [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => 'Earnings',
                'fill' => true,
                'data' => $data,
                'backgroundColor' => 'rgba(78, 115, 223, 0.05)',
                'borderColor' => 'rgba(78, 115, 223, 1)'
            ]
        ]
    ];
    
    $chartDataJson = json_encode($chartData);  
    ?>
    <canvas data-bss-chart='{"type":"<?php echo $type?>","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
    <?php
  }

function weekly_chart($type = 'line'){
    global $db;
    $sql = "SELECT YEAR(t.created_at) AS year, WEEK(t.created_at) AS week, SUM(CASE
            WHEN r.type = 'day' THEN co.priceDay
            WHEN r.type = 'night' THEN co.priceNight
            ELSE 0 
            END) AS total_sales
            FROM transactions t
            JOIN rentals r ON t.id = r.transact_id
            JOIN cottages co ON r.cottage_id = co.id
            WHERE t.status = 'Proceed' 
            AND DATE_FORMAT(t.created_at, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')
            GROUP BY YEAR(t.created_at), WEEK(t.created_at)
            ORDER BY YEAR(t.created_at), WEEK(t.created_at);";
            
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    $labels = [];
    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $weekLabel = "Week " . $row['week'] . " (" . $row['year'] . ")";
        $labels[] = $weekLabel;
        $data[] = $row['total_sales'];
    }
    $chartData = [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => 'Earnings',
                'fill' => true,
                'data' => $data,
                'backgroundColor' => 'rgba(78, 115, 223, 0.05)',
                'borderColor' => 'rgba(78, 115, 223, 1)'
            ]
        ]
    ];
    
    $chartDataJson = json_encode($chartData);
    
?>
<canvas data-bss-chart='{"type":"<?php echo $type?>","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
<?php
}  

function month_chart($type = 'line'){
    global $db;
    $sql = "SELECT YEAR(t.created_at) AS year, MONTH(t.created_at) AS month, SUM(CASE
        WHEN r.type = 'day' THEN co.priceDay
        WHEN r.type = 'night' THEN co.priceNight
        ELSE 0 
        END) AS total_sales
        FROM transactions t
        JOIN rentals r ON t.id = r.transact_id
        JOIN cottages co ON r.cottage_id = co.id
        WHERE t.status = 'Proceed' AND DATE_FORMAT(t.created_at, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')
        GROUP BY YEAR(t.created_at), MONTH(t.created_at)
        ORDER BY YEAR(t.created_at), MONTH(t.created_at);";
        
    $stmt = $db->prepare($sql);
    $stmt->execute();
  
    $labels = [];
    $data = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $monthName = date("M", mktime(0, 0, 0, $row['month'], 10));
    $labels[] = $monthName . ' ' . $row['year'];
    $data[] = $row['total_sales'];
    }
    $chartData = [
    'labels' => $labels,
    'datasets' => [
    [
    'label' => 'Earnings',
    'fill' => true,
    'data' => $data,
    'backgroundColor' => 'rgba(78, 115, 223, 0.05)',
    'borderColor' => 'rgba(78, 115, 223, 1)'
    ]
    ]
    ];
  
  
    $chartDataJson = json_encode($chartData);
    ?>
    <canvas data-bss-chart='{"type":"<?php echo $type?>","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
    <?php
  }
  

  function annual_chart($type = 'line'){
    global $db;
    $sql = "SELECT YEAR(t.created_at) AS year, MONTH(t.created_at) AS month, SUM(CASE
        WHEN r.type = 'day' THEN co.priceDay
        WHEN r.type = 'night' THEN co.priceNight
        ELSE 0 
        END) AS total_sales
        FROM transactions t
        JOIN rentals r ON t.id = r.transact_id
        JOIN cottages co ON r.cottage_id = co.id
        WHERE t.status = 'Proceed' AND DATE_FORMAT(t.created_at, '%Y') = DATE_FORMAT(CURRENT_DATE, '%Y')
        GROUP BY YEAR(t.created_at), MONTH(t.created_at)
        ORDER BY YEAR(t.created_at), MONTH(t.created_at);";
        
    $stmt = $db->prepare($sql);
    $stmt->execute();
  
    $labels = [];
    $data = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $monthName = date("M", mktime(0, 0, 0, $row['month'], 10));
    $labels[] = $monthName . ' ' . $row['year'];
    $data[] = $row['total_sales'];
    }
    $chartData = [
    'labels' => $labels,
    'datasets' => [
    [
    'label' => 'Earnings',
    'fill' => true,
    'data' => $data,
    'backgroundColor' => 'rgba(78, 115, 223, 0.05)',
    'borderColor' => 'rgba(78, 115, 223, 1)'
    ]
    ]
    ];
  
  
    $chartDataJson = json_encode($chartData);
    ?>
    <canvas data-bss-chart='{"type":"<?php echo $type?>","data":<?php echo $chartDataJson; ?>,"options":{"maintainAspectRatio":false,"legend":{"display":false,"labels":{"fontStyle":"normal"}},"title":{"fontStyle":"normal"},"scales":{"xAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"],"drawOnChartArea":false},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}],"yAxes":[{"gridLines":{"color":"rgb(234, 236, 244)","zeroLineColor":"rgb(234, 236, 244)","drawBorder":false,"drawTicks":false,"borderDash":["2"],"zeroLineBorderDash":["2"]},"ticks":{"fontColor":"#858796","fontStyle":"normal","padding":20}}]}}}'></canvas>
    <?php
  }
