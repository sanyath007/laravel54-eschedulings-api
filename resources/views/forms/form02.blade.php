<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>หลักฐานการเบิกจ่ายเงินตอบแทนการปฏิบัติงานนอกเวลาราชการ</title>
        <link rel="stylesheet" href="{{ asset('/css/pdf.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h4 style="margin: 0px;">หลักฐานการเบิกจ่ายเงินตอบแทนการปฏิบัติงานนอกเวลาราชการ</h4>
            </div>

            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%; text-align: right; padding: 0;" colspan="3">
                        <h4 style="margin: 0;">
                            ส่วนราชการ 
                            <span style="margin: 0px;">
                                โรงพยาบาลเทพรัตน์นครราชสีมา
                            </span>
                        </h4>
                    </td>
                    <td style="padding: 0;" colspan="3">
                        <h4 style="margin: 0;">
                            <span style="margin: 0 0 0 10px;">จังหวัดนครราชสีมา</span>
                            <span style="margin: 0 0 0 10px;">
                                ประจำเดือน <span>{{ convDbDateToLongThMonth($schedule->month) }}</span>
                            </span>
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding: 0;" colspan="3">
                        <h4 style="margin: 0;">
                            หน่วยงาน 
                            @if($schedule->division)
                                <span style="margin: 0px;">{{ $schedule->division->ward_name }}</span>
                            @endif
                            <span style="margin: 0 0 0 5px;">{{ $schedule->depart->depart_name }}</span>
                        </h4>
                    </td>
                    <td style="padding: 0;" colspan="3">
                        <h4 style="margin: 0;">
                            <span style="margin: 0 0 0 10px;">
                                {{ $schedule->depart->faction->faction_name }}
                            </span>
                            <span style="margin: 0 0 0 10px;">
                                โรงพยาบาลเทพรัตน์นครราชสีมา
                            </span>
                        </h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table style="width: 100%;" class="table" border="1">
                            <tr style="font-size: 14px; padding: 0;">
                                <td style="width: 2%; text-align: center; padding: 0;" rowspan="2">ลำดับ</td>
                                <td style="text-align: center;" rowspan="2">ชื่อ-สกุล</td>
                                <td class="bc-browsers" style="width: 3%;" rowspan="2">
                                    <div class="bc-head-txt-label">ตำแหน่ง</div>
                                </td>
                                <td class="bc-browsers" style="width: 3%; padding: 0;" rowspan="2">
                                    <div class="bc-head-txt-label">ค่าตอบแทน</div>
                                </td>
                                <td style="text-align: center;" colspan="{{ date('t', strtotime($schedule->month.'-01')) }}">วันที่</td>
                                <td style="width: 2.5%; text-align: center; padding: 0;" rowspan="2">จำนวน<br>รวม<br>OT</td>
                                <td style="width: 4.5%; text-align: center; padding: 0;" rowspan="2">จำนวน<br>เงิน</td>
                                <td style="width: 3%; text-align: center; padding: 0;" rowspan="2">ว/ด/ป<br>ที่รับเงิน</td>
                                <td style="width: 4%; text-align: center; padding: 0;" rowspan="2">ลายมือชื่อ<br>ผู้รับเงิน</td>
                                <td style="width: 3%; text-align: center; padding: 0;" rowspan="2">หมายเหตุ</td>
                            </tr>
                            <tr style="font-size: 14px; padding: 0;">
                                @for($d = 0; $d < date('t', strtotime($schedule->month.'-01')); $d++)
                                    <?php $currDate = date('Y-m-d', strtotime($schedule->month.'-'.($d + 1))); ?>

                                    <td style="width: 2%; text-align: center; padding: 0; {{ setHolidayColumnColor($currDate, $holidays, '#bac2c6') }}">
                                        {{ $d + 1 }}
                                    </td>
                                @endfor
                            </tr>

                            <?php $row = 0; $sum_ot = 0.0; $total_ot_amt = 0.0; $total_ot = 0.0; ?>
                            @foreach($schedule->shifts as $detail)
                                <?php
                                    $arrShifts = explode(',', $detail->shifts);

                                    /** Full position name */
                                    // $position = $detail->person->position->position_name;
                                    // if($detail->person->academic) {
                                    //     $position .= $detail->person->academic->ac_name;
                                    // }

                                    /** Short position name and OT rate according to position */
                                    if ($detail->person->position->position_id == 22) {
                                        $position = 'RN';
                                        $ot_rate = 600;
                                    } else if (in_array($detail->person->position->position_id, [126])) {
                                        $position = 'PN';
                                        $ot_rate = 360;
                                    } else if (in_array($detail->person->position->position_id, [89])) {
                                        $position = 'NA';
                                        $ot_rate = 330;
                                    }

                                    $sum_ot = (float)$detail->ot * (float)$ot_rate;
                                    /** Calculate total */
                                    $total_ot_amt += (float)$detail->ot;
                                    $total_ot += $sum_ot;
                                ?>
                                <tr>
                                    <td style="text-align: center; padding: 0;">{{ ++$row }}</td>
                                    <td style="padding: 0 2px;">
                                        {{ $detail->person->prefix->prefix_name.$detail->person->person_firstname. ' ' .$detail->person->person_lastname }}
                                    </td>
                                    <td style="text-align: center; padding: 0 2px; font-size: 16px;">
                                        {{ $position }}
                                    </td>
                                    <td style="text-align: center; padding: 0; font-size: 16px;">
                                        {{ $ot_rate }}
                                    </td>
                                    <?php $i = 1; ?>
                                    @foreach($arrShifts as $shift)
                                        <?php $curr_date = date('Y-m-d', strtotime($schedule->month.'-'.($i++))); ?>

                                        <td style="text-align: center; font-size: 16px; padding: 0; {{ setHolidayColumnColor($curr_date, $holidays, '#bac2c6') }}">
                                            {{ str_replace('|', ' ' , $shift) }}
                                        </td>
                                    @endforeach
                                    <td style="text-align: center; padding: 0; font-size: 16px;">
                                        {{ $detail->ot }}
                                    </td>
                                    <td style="text-align: right; padding: 0 2px 0 0; font-size: 16px;">
                                        {{ number_format($sum_ot, 2) }}
                                    </td>
                                    <td style="text-align: center; padding: 0;"></td>
                                    <td style="text-align: center; padding: 0;"></td>
                                    <td style="text-align: center; padding: 0;">
                                        {{ $detail->remark }}
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td style="text-align: center; padding: 0;" colspan="35">รวม</td>
                                <td style="text-align: center; padding: 0; font-size: 16px;">
                                    {{ $total_ot_amt }}
                                </td>
                                <td style="text-align: right; padding: 0 1px 0 0; font-size: 16px;">
                                    {{ number_format($total_ot, 2) }}
                                </td>
                                <td colspan="3"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- // Summary Sction -->
                <tr>
                    <td colspan="6">
                        <div style="margin-top: 5px;">
                            <p style="margin: 0 50px;">
                                รวมเป็นเงิน (ตัวอักษร) 
                                <span class="dot" style="margin-left: 2rem;">( {{ baht_text($total_ot) }} )</span>
                            </p>
                            <p style="margin: 0 50px;">
                                ขอรับรองว่าผู้มีรายชื่อข้างต้นปฏิบัติงานนอกเวลาจริง
                            </p>
                        </div>
                    </td>
                </tr>
                <!-- // Summary Sction -->

                <!-- // Signatures of head of depart and faction -->
                <tr>
                    <td colspan="3">
                        <div style="margin-top: 20px;">
                            <p style="margin-left: 150px;">
                                (ลงชื่อ)<span class="dot">......................................................</span>ผู้รับรองการปฏิบัติงาน/หัวหน้างาน
                            </p>
                            <p style="margin-left: 200px;">
                                (<span class="dot">{{ $controller->prefix->prefix_name.$controller->person_firstname. ' ' .$controller->person_lastname }}</span>)
                            </p>
                            <p style="margin-left: 150px;">
                                ตำแหน่ง <span class="dot">{{ $controller->position->position_name }}{{ $controller->academic ? $controller->academic->ac_name : '' }}</span>
                            </p>
                        </div>
                    </td>
                    <td colspan="3">
                        <div style="margin-top: 20px;">
                            <p style="margin-left: 50px;">
                                (ลงชื่อ)<span class="dot">......................................................</span>ผู้จ่ายเงิน
                            </p>
                            <p style="margin-left: 100px;">
                                (<span class="dot">{{ $headOfFinance->prefix->prefix_name.$headOfFinance->person_firstname. ' ' .$headOfFinance->person_lastname }}</span>)
                            </p>
                            <p style="margin-left: 50px;">
                                ตำแหน่ง <span class="dot">{{ $headOfFinance->position->position_name }}{{ $headOfFinance->academic ? $headOfFinance->academic->ac_name : '' }}</span>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="margin-top: 20px;">
                            <p style="margin-left: 150px;">
                                (ลงชื่อ)<span class="dot">......................................................</span>ผู้รับรองการปฏิบัติงาน/หัวหน้ากลุ่มภารกิจ
                            </p>
                            <p style="margin-left: 200px;">
                                (<span class="dot">{{ $headOfFaction->prefix->prefix_name.$headOfFaction->person_firstname. ' ' .$headOfFaction->person_lastname }}</span>)
                            </p>
                            <p style="margin-left: 150px;">
                                ตำแหน่ง <span class="dot">{{ $headOfFaction->position->position_name }}{{ $headOfFaction->academic ? $headOfFaction->academic->ac_name : '' }}</span>
                            </p>
                        </div>
                    </td>
                    <td colspan="3">
                        <div style="margin-top: 20px;">
                            <p style="margin-left: 50px;">
                                (ลงชื่อ)<span class="dot">......................................................</span>ผู้อนุมัติ
                            </p>
                            <p style="margin-left: 100px;">
                                (<span class="dot">{{ $director->prefix->prefix_name.$director->person_firstname. ' ' .$director->person_lastname }}</span>)
                            </p>
                            <p style="margin-left: 50px;">
                                ผู้อำนวยการโรงพยาบาลเทพรัตน์นครราชสีมา
                            </p>
                        </div>
                    </td>
                </tr>
                <!-- // Signatures of head of depart and faction -->
            </table>
        </div>
        <!-- /.container -->
    </body>
</html>