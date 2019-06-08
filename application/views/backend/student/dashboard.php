
<!-- Resources -->

<style>
    #chartdiv2, #chartdiv {
        width		: 100%;
        height		: 300px;
        font-size	: 11px;
    }					
    .style2 {font-size: 24px}
</style>

<!-- FullCalendar -->
<link href="assets/vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">

<?php $count_all = $this->db->count_all('student') + $this->db->count_all('teacher') + $this->db->count_all('parent') + $this->db->count_all('librarian') + $this->db->count_all('accountant'); ?>
<?php
$check = array('date' => date('Y-m-d'), 'status' => '1');
$query = $this->db->get_where('attendance', $check);
$present_today = $query->num_rows();
?>
<div class="row">
    <div class="col-md-12" role="main">
        <div class="row">
            <div class="col-md-4">
                <ul class="site-stats">
                    <li><a href="<?php echo site_url('items'); ?>"><h3><div class="col-md-4 stats-left" style="background-color:#4e7d2a"><i class="fa fa-group"></i></div>  <div class="col-md-8 stats-right  text-right"> Total <?php echo get_phrase('student'); ?> : <strong><?php echo $this->db->count_all('student'); ?></strong></div></h3></a> </li>
                    <li><a href="<?php echo site_url('item_kits'); ?>"><h3> <div class="col-md-4 stats-left" style="background-color:#489ee7"><i class="entypo-user"></i></div>  <div class="col-md-8 stats-right  text-right">  Total <?php echo get_phrase('teacher'); ?>  :  <strong><?php echo $this->db->count_all('teacher'); ?></strong></div></h3></a></li>

                </ul>
            </div>
            <div class="col-md-4">
                <ul class="site-stats">
                    <li> <a href="<?php echo site_url('sales'); ?>"><h3> <div class="col-md-4 stats-left" style="background-color:#3bbc63"><i class="entypo-users"></i></div>  <div class="col-md-8 stats-right  text-right">  Total <?php echo get_phrase('parent'); ?>  : <strong><?php echo $this->db->count_all('parent'); ?></strong></div> </h3></a></li>
                    <li>  <a href="<?php echo site_url('customers'); ?>"><h3> <div class="col-md-4 stats-left" style="background-color:#fb5d5d"><i class="entypo-book"></i></div>  <div class="col-md-8 stats-right  text-right">  Total <?php echo get_phrase('librarian'); ?>  : <strong><?php echo $this->db->count_all('librarian'); ?></strong></div></h3></a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="site-stats">
                    <li> <a href="<?php echo site_url('employees'); ?>"><h3> <div class="col-md-4 stats-left" style="background-color:#f7941d"><i class="entypo-user-add"></i></div>  <div class="col-md-8 stats-right  text-right">  Total <?php echo get_phrase('Accountant'); ?>  :  <strong><?php echo $this->db->count_all('accountant'); ?></strong></div></h3></a></li>
                    <li>  <a href="<?php echo site_url('giftcards'); ?>"><h3> <div class="col-md-4 stats-left" style="background-color:#797b0e"><i class="fa fa-gear"></i></div>  <div class="col-md-8  stats-right text-right">  <?php echo get_phrase('all_enquiry'); ?>  : <strong><?php echo $this->db->count_all('enquiry'); ?></strong></div></h3></a></li>
                </ul>
            </div>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>Calendar Events <small>Sessions</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div id='calendar'></div>

            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo get_phrase('New_Students'); ?></h2>
                <div class="clearfix"></div>
            </div>
            <ul class="list-unstyled top_profiles scroll-view">
                <?php
                $new_students_list = $this->crud_model->new_student_list();
                foreach ($new_students_list as $student):
                    ?>
                    <li class="media event">
                        <a class="pull-left border-aero profile_thumb" style="background-image:url('<?php echo $student['face_file'] ?>');">
                        </a>
                        <div class="media-body">
                            <a class="title" href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type')?>/student_information/<?php echo $student["class_id"]?>"><?php echo $student['name'] ?></a>
                            <p><strong><?php echo $student['birthday'] ?>. </strong> <?php echo $student['sex'] ?> </p>
                            <p> <small>Phone: <?php echo $student['phone'] ?>,</small>
                                <strong>Email: <?php echo $student['email'] ?></strong>
                            </p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>


<script src="assets/vendors/echarts/dist/echarts.min.js"></script>

<!-- NProgress -->
<script src="assets/vendors/nprogress/nprogress.js"></script>
<!-- FullCalendar -->
<script src="assets/vendors/moment/min/moment.min.js"></script>
<script src="assets/vendors/fullcalendar/dist/fullcalendar.min.js"></script>
<script>
    $(function () {
        init_calendar();
    });
    function  init_calendar() {

        if (typeof ($.fn.fullCalendar) === 'undefined') {
            return;
        }
        console.log('init_calendar');
        var date = new Date(),
                d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear(),
                started,
                categoryClass;
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                $('#fc_create').click();
                started = start;
                ended = end;
                $(".antosubmit").on("click", function () {
                    var title = $("#title").val();
                    if (end) {
                        ended = end;
                    }

                    categoryClass = $("#event_type").val();
                    if (title) {
                        calendar.fullCalendar('renderEvent', {
                            title: title,
                            start: started,
                            end: end,
                            allDay: allDay
                        },
                                true // make the event "stick"
                                );
                    }

                    $('#title').val('');
                    calendar.fullCalendar('unselect');
                    $('.antoclose').click();
                    return false;
                });
            },
            eventClick: function (calEvent, jsEvent, view) {
                $('#fc_edit').click();
                $('#title2').val(calEvent.title);
                categoryClass = $("#event_type").val();
                $(".antosubmit2").on("click", function () {
                    calEvent.title = $("#title2").val();
                    calendar.fullCalendar('updateEvent', calEvent);
                    $('.antoclose2').click();
                });
                calendar.fullCalendar('unselect');
            },
            editable: true,
            events: [<?php
                $notices = $this->db->get('noticeboard')->result_array();
                foreach ($notices as $row):
                    ?>
                    {
                        title: "<?php echo $row['notice_title']; ?>",
                        start: new Date(<?php echo date('Y', $row['create_timestamp']); ?>, <?php echo date('m', $row['create_timestamp']) - 1; ?>, <?php echo date('d', $row['create_timestamp']); ?>),
                        end: new Date(<?php echo date('Y', $row['create_timestamp']); ?>, <?php echo date('m', $row['create_timestamp']) - 1; ?>, <?php echo date('d', $row['create_timestamp']); ?>)
                    },
    <?php
endforeach
?>
            ]
        });
    }
</script>
