 <hr>
        <link href="/assets/css/idcard.css" rel="stylesheet" type="text/css">    
            <!----CREATION FORM STARTS---->
            <div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                    <?php echo form_open(base_url() . 'index.php?admin/student_id_card/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
                            <div class="panel-body">

                                <div class="col-sm-12">

                                <div class="row">
                                 <div class="form-group">
                            <h3><p><b>Student ID Card</b></p></h3>
                            <!--                        <label for="reg_input_currency">Previous Education Details</label><br/>-->
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="reg_input" class="req">Class</label>
                                    <select name="class" class="form-control">
                                        <option value=""><?php echo get_phrase('select');?></option>
                                        <?php 
                                            $classes = $this->db->get('class')->result_array();
                                            foreach($classes as $row):
                                         ?>
                                    <option value="<?php echo $row['class_id'];?>">
                                        <?php echo $row['name'];?>
                                    </option>
                                <?php
                                endforeach;
                              ?>
                            </select>
                                <div class="school_val_error" id="Student_id" style="display:none"></div>                                
                            </div>  
                                <div class="form-group col-sm-3" id="batch">
                                    <label for="reg_input" class="req">Section</label>
                                    <select class="form-control" name="section_id" id="Student_section_id">
                                        <option value="">Select Section</option>
                                    </select>
                                    <div class="school_val_error" id="Student_batchid_em_" style="display:none"></div>                                
                                </div>
                                    <div class="form-group col-sm-3" id="type">
                                   <label for="reg_input" class="req">Id Type</label>
                                    <select class="form-control" name="Student[type]" id="Student_type">
                                        <option value="prompt">Select ID Template</option>
                                        <option value="horizontal">Horizontal ID Card</option>
                                        <option value="vertical">Vertical ID Card</option>
                                    </select>                                
                                </div>
                                <div class="form-group col-sm-2">
                                    <label> &nbsp; &nbsp;</label>
                                    <p> &nbsp;&nbsp;<a href="javascript:viewstudent()" class="btn btn-info">Generate ID Card</a> </p> 
                                </div>
                            </div>
                        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="col-sm-12">
        <div class="row" id="student_idcard" style="display:none;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Student ID Card</h4>
                    <p>  
                        <input type="button" onclick="printDiv('print')" value="Print ID Card" class="btn btn-danger"/>
                    </p>
                </div>
                <div  id="print">
                    <div class="panel-body" id="stuidcard">
                        <div class="col-sm-4">
                            <div id="new">
                                <div id="holder">
                                    <div class="box">
                                        <div class="tie">
                                            <h1>Elite High School Entebbe</h1>
                                            <img src="" alt="">
                                        </div>
                                        <h1 class="id">
                                            <b>STUDENT ID CARD</b>
                                        </h1>
                                        <img src="" alt="">
                                        <h1 class="rname">Name:</h1>
                                        <h1 class="postitle">Class:</h1>
                                        <h1 class="postitle">DOB:</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function viewstudent()
    {

        var value = $('#type option:selected').val();

        $('#stuidcard').empty();
        var courseid = $('#Student_courseid').val();
        var batchid = $('#Student_batchid').val();
        if (courseid === "" || batchid === "" || value == "prompt") {
            alert("Plese select all the field");
            return;
        }
        $.ajax({
            type: "POST",
            url: "view_student",
            data: {courseid: courseid, batchid: batchid, type: value},
            dataType: "html",
            success: function (data) {
                $('#student_idcard').show("slow");
                $('#stuidcard').append(data);

            }
        });
    }


    function printDiv(divName) {
        var divToPrint = document.getElementById(divName);
        var popupWin = window.open('', '', 'width=300,height=300');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">');
        popupWin.document.write('<link href="/assets/css/idcard.css" rel="stylesheet" type="text/css" media="print"/>');
        popupWin.document.write('<link href="/css/assets/css/minified/ccebootstrap.min.css" rel="stylesheet" type="text/css">');
        popupWin.document.write('<link href="/css/assets/css/minified/core.min.css" rel="stylesheet" type="text/css">');
        popupWin.document.write(divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }

</script>