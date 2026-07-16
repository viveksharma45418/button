<?php
/*
Template Name: Click Report
*/

get_header();

global $wpdb;

$table = $wpdb->prefix . 'button_clicks';

$from = $_GET['from'] ?? date('Y-m-d');
$to   = $_GET['to'] ?? date('Y-m-d');

$where = '';

if (!empty($from) && !empty($to)) {

    $where = $wpdb->prepare(
        " WHERE DATE(created_at) BETWEEN %s AND %s ",
        $from,
        $to
    );
}

$total_clicks = $wpdb->get_var(
    "SELECT COUNT(*) FROM $table $where"
);

$unique_users = $wpdb->get_var(
    "SELECT COUNT(DISTINCT user_ip) FROM $table $where"
);

$button_clicks = $wpdb->get_results(

    "SELECT button_name,
            COUNT(*) as total_clicks
     FROM $table
     $where
     GROUP BY button_name
     ORDER BY total_clicks DESC"
);

$selected_button = $_GET['button'] ?? '';

$details = [];

if($selected_button){

    $sql = $wpdb->prepare(
        "SELECT *
         FROM $table
         WHERE button_name = %s
         AND DATE(created_at) BETWEEN %s AND %s
         ORDER BY created_at DESC",
        $selected_button,
        $from,
        $to
    );

    $details = $wpdb->get_results($sql);
}
?>

<style>



.report-box{
    max-width:1200px;
    margin:40px auto;
    padding:20px;
}

.report-title{
    font-size:40px;
    font-weight:700;
    margin-bottom:25px;
    color:#1f2937;
}

.filter-box{
    background:#fff;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
    margin-bottom:30px;
}

.row-flex{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    align-items:end;
}

.field{
    flex:1;
    min-width:250px;
}

.field label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
    color:#374151;
}

.field input{
    width:100%;
    padding:14px;
    border:1px solid #d1d5db;
    border-radius:10px;
    font-size:16px;
}

.btn{
    background:#0ea5e9;
    color:#fff;
    border:none;
    padding:14px 30px;
    border-radius:10px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn:hover{
    opacity:.9;
}

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.stat-card{
    background:linear-gradient(135deg,#0ea5e9,#2563eb);
    color:#fff;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(37,99,235,.2);
}

.stat-card h4{
    margin:0;
    font-size:16px;
    opacity:.9;
}

.stat-card h2{
    margin:10px 0 0;
    font-size:40px;
    font-weight:700;
}

.table-box{
    background:#fff;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#111827 !important;
    color:#fff;
    padding:18px;
    text-align:left;
}

table td{
    padding:16px 18px;
    border-bottom:1px solid #e5e7eb;
}

table tr:hover{
    background:#f9fafb;
}

.click-count{
    font-weight:700;
    color:#2563eb;
}

.no-record{
    text-align:center;
    padding:30px;
    font-weight:600;
}

.details-wrapper{
    
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
      max-width: 1200px;
    margin: 40px auto;
}

.details-header{
    background:linear-gradient(135deg,#2563eb,#1e40af);
    padding:25px;
    color:#fff;
}

.details-header h3{
    margin:0;
    font-size:28px;
    font-weight:700;
}

.details-header p{
    margin:8px 0 0;
    opacity:.9;
    font-size:14px;
}

.details-table{
    padding:20px;
}

.details-table table{
    width:100%;
    border-collapse:collapse;
}

.details-table th{
    background:#111827;
    color:#fff;
    padding:16px;
    text-align:left;
    font-size:14px;
}

.details-table td{
    padding:15px;
    border-bottom:1px solid #e5e7eb;
}

.details-table tr:nth-child(even){
    background:#f8fafc;
}

.details-table tr:hover{
    background:#eef4ff;
}

.url-box{
    max-width:350px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.ip-badge{
    background:#eff6ff;
    color:#2563eb;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

.date-badge{
    background:#ecfdf5;
    color:#059669;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

@media(max-width:768px){

    .details-header h3{
        font-size:20px;
    }

    .details-table{
        overflow-x:auto;
    }

    .details-table table{
        min-width:800px;
    }
}

@media(max-width:768px){

    .report-title{
        font-size:28px;
    }

    .row-flex{
        flex-direction:column;
    }

    .field{
        width:100%;
    }

    .btn{
        width:100%;
    }
}

</style>

<div class="report-box">

    <h2 class="report-title">
         Button Click Summary Report
    </h2>

    <div class="filter-box">

        <form method="GET">

            <div class="row-flex">

                <div class="field">
                    <label>From Date</label>
                    <input
                        type="date"
                        name="from"
                        value="<?php echo esc_attr($from); ?>">
                </div>

                <div class="field">
                    <label>To Date</label>
                    <input
                        type="date"
                        name="to"
                        value="<?php echo esc_attr($to); ?>">
                </div>

                <div>
                    <button type="submit" class="btn">
                        Search Report
                    </button>
                </div>

            </div>

        </form>

    </div>

    <div class="stats">

        <div class="stat-card">
            <h4>Total Clicks</h4>
            <h2><?php echo (int)$total_clicks; ?></h2>
        </div>

        <div class="stat-card">
            <h4>Unique Users</h4>
            <h2><?php echo (int)$unique_users; ?></h2>
        </div>

    </div>

    <div class="table-box">

        <table>

            <tr>
                <th>Button Name</th>
                <th>Total Clicks</th>
            </tr>

            <?php if($button_clicks){ ?>

                <?php foreach($button_clicks as $row){ ?>

                    <tr>

                        <td>
                            <?php
                            echo ucwords(
                                str_replace('_',' ',$row->button_name)
                            );
                            ?>
                        </td>

                       <td class="click-count">
    <a href="?from=<?php echo $from; ?>&to=<?php echo $to; ?>&button=<?php echo urlencode($row->button_name); ?>">
        <?php echo $row->total_clicks; ?>
    </a>
</td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="2" class="no-record">
                        No Records Found
                    </td>
                </tr>

            <?php } ?>

        </table>

    </div>

</div>

<?php if($selected_button){ ?>

<div class="details-wrapper">

    <div class="details-header">

        <h3>
            ðŸ“‹ Details:
            <?php echo ucwords(str_replace('_',' ',$selected_button)); ?>
        </h3>

        <p>
            Complete click history for selected button
        </p>

    </div>

    <div class="details-table">

        <table>

            <tr>
                <th>ID</th>
                <th>Button Name</th>
                <th>Page URL</th>
                <th>User IP</th>
                <th>Date & Time</th>
            </tr>

            <?php foreach($details as $row){ ?>

            <tr>

                <td>
                    #<?php echo $row->id; ?>
                </td>

                <td>
                    <?php
                    echo ucwords(
                        str_replace('_',' ',$row->button_name)
                    );
                    ?>
                </td>

                <td>
                    <div class="url-box">
                        <?php echo esc_html($row->page_url); ?>
                    </div>
                </td>

                <td>
                    <span class="ip-badge">
                        <?php echo esc_html($row->user_ip); ?>
                    </span>
                </td>

                <td>
                    <span class="date-badge">
                        <?php
                        echo date(
                            'd-m-Y h:i A',
                            strtotime($row->created_at)
                        );
                        ?>
                    </span>
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

<?php } ?>

<?php get_footer(); ?>
