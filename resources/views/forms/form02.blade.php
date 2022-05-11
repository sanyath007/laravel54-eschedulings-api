<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>ตารางปฏิบัติงานในและนอกเวลาราชการ</title>
        <link rel="stylesheet" href="{{ asset('/css/pdf.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h3 style="margin: 0px;">ตารางปฏิบัติงานในและนอกเวลาราชการ</h3>
            </div>
            <div class="content">
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
                                หน่วยงาน <span style="margin: 0px;">{{ $schedule->depart->depart_name }}</span>
                            </h4>
                        </td>
                        <td style="padding: 0;" colspan="3">
                            <h4 style="margin: 0;">
                                <span style="margin: 0 0 0 15px;">
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
                                    <td style="width: 4%; text-align: center;" rowspan="2">ตำแหน่ง</td>
                                    <td style="text-align: center;" colspan="{{ date('t', strtotime($schedule->month.'-01')) }}">วันที่</td>
                                    <td style="width: 3%; text-align: center; padding: 0;" colspan="3">
                                        วันทำการ
                                    </td>
                                    <td style="width: 2.5%; text-align: center; padding: 0;" rowspan="2">รวม</td>
                                    <td style="width: 2.5%; text-align: center; padding: 0;" rowspan="2">OT</td>
                                    <td style="width: 5%; text-align: center; padding: 0;" rowspan="2">หมายเหตุ</td>
                                </tr>
                                <tr style="font-size: 14px; padding: 0;">
                                    @for($d = 0; $d < date('t', strtotime($schedule->month.'-01')); $d++)
                                        <?php $currDate = date('Y-m-d', strtotime($schedule->month.'-'.($d + 1))); ?>

                                        <td style="width: 2%; text-align: center; padding: 0; {{ setHolidayColumnColor($currDate, $holidays, '#bac2c6') }}">
                                            {{ $d + 1 }}
                                        </td>
                                    @endfor
                                    <td style="width: 2%; text-align: center; padding: 0;">ช</td>
                                    <td style="width: 2%; text-align: center; padding: 0;">บ</td>
                                    <td style="width: 2%; text-align: center; padding: 0;">ด</td>
                                </tr>

                                <?php $row = 0; ?>
                                @foreach($schedule->shifts as $detail)
                                    <?php
                                        $arrShifts = explode(',', $detail->shifts);

                                        // Full position name
                                        // $position = $detail->person->position->position_name;
                                        // if($detail->person->academic) {
                                        //     $position .= $detail->person->academic->ac_name;
                                        // }

                                        // Short position name
                                        if ($detail->person->position->position_id == 22) {
                                            $position = 'RN';
                                        } else if (in_array($detail->person->position->position_id, [126])) {
                                            $position = 'PN';
                                        } else if (in_array($detail->person->position->position_id, [89])) {
                                            $position = 'NA';
                                        }
                                    ?>
                                    <tr>
                                        <td style="text-align: center; padding: 0;">{{ ++$row }}</td>
                                        <td style="padding: 0 2px;">
                                            {{ $detail->person->prefix->prefix_name.$detail->person->person_firstname. ' ' .$detail->person->person_lastname }}
                                        </td>
                                        <td style="text-align: center; padding: 0 2px; font-size: 16px;">
                                            {{ $position }}
                                        </td>
                                        <?php $i = 1; ?>
                                        @foreach($arrShifts as $shift)
                                            <?php $curr_date = date('Y-m-d', strtotime($schedule->month.'-'.($i++))); ?>

                                            <td style="text-align: center; font-size: 16px; padding: 0; {{ setHolidayColumnColor($curr_date, $holidays, '#bac2c6') }}">
                                                {{ str_replace('|', ' ' , $shift) }}
                                            </td>
                                        @endforeach
                                        <td style="text-align: center; font-size: 16px; padding: 0;">
                                            {{ $detail->m }}
                                        </td>
                                        <td style="text-align: center; font-size: 16px; padding: 0;">
                                            {{ $detail->e }}
                                        </td>
                                        <td style="text-align: center; font-size: 16px; padding: 0;">
                                            {{ $detail->n }}
                                        </td>
                                        <td style="text-align: center; font-size: 16px; padding: 0;">
                                            {{ $detail->total }}
                                        </td>
                                        <td style="text-align: center; font-size: 16px; padding: 0;">
                                            {{ $detail->ot }}
                                        </td>
                                        <td style="text-align: center; font-size: 14px; padding: 0;">
                                            {{ $detail->remark }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <div style="margin-top: 5px;">
                                <p style="margin: 0 50px;">
                                    หมายเหตุ : {{ $schedule->remark }}
                                </p>
                                <p style="margin: 0 50px;">
                                    รวมเป็นเงิน <span class="dot">

                                    </span>
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="margin-top: 20px;">
                                <p style="margin-left: 150px;">
                                    (ลงชื่อ)<span class="dot">......................................................</span>หัวหน้ากลุ่มงาน
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
                                    (ลงชื่อ)<span class="dot">......................................................</span>
                                </p>
                                <p style="margin-left: 100px;">
                                    (<span class="dot">{{ $headOfFaction->prefix->prefix_name.$headOfFaction->person_firstname. ' ' .$headOfFaction->person_lastname }}</span>)
                                </p>
                                <p style="margin-left: 50px;">
                                    ตำแหน่ง <span class="dot">{{ $headOfFaction->position->position_name }}{{ $headOfFaction->academic ? $headOfFaction->academic->ac_name : '' }}</span>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>