<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>ตารางการปฏิบัติงานนอกเวลาราชการ</title>
        <link rel="stylesheet" href="{{ asset('/css/pdf.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h3 style="margin: 0px;">ตารางการปฏิบัติงานนอกเวลาราชการ</h3>
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
                        <td style="text-align: center; padding: 0;" colspan="6">
                            <h4 style="margin: 0;">
                                หน่วยงาน <span style="margin: 0px;">{{ $schedule->depart->depart_name }}</span>
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

                                <?php
                                    $row = 0;

                                    /** RN and NA */
                                    $total_m = 0.00;
                                    $total_e = 0.00;
                                    $total_n = 0.00;
                                    $total_b = 0.00;
                                    $total_working = 0.00;
                                    $total_ot = 0.00;
                                    $total_en = 0.00;

                                    /** PN */
                                    $total_pn_m = 0.00;
                                    $total_pn_e = 0.00;
                                    $total_pn_n = 0.00;
                                    $total_pn_b = 0.00;
                                    $total_pn_working = 0.00;
                                    $total_pn_ot = 0.00;
                                    $total_pn_en = 0.00;

                                    /** All OT rate */
                                    $ot_rn_rate = 600;
                                    $ot_pn_rate = 360;
                                    $ot_na_rate = 330;
                                    $en_rn_rate = 240;
                                    $en_pn_rate = 145;

                                    /** Net */
                                    $net_ot  = 0.00;
                                    $net_en  = 0.00;
                                    $net_total  = 0.00
                                ?>
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

                                        if (in_array($detail->person->position->position_id, [126])) {
                                            $total_pn_m += (float)$detail->wm;
                                            $total_pn_e += (float)$detail->we;
                                            $total_pn_n += (float)$detail->wn;
                                            $total_pn_b += (float)$detail->wb;
                                            $total_pn_working += (float)$detail->working;
                                            $total_pn_ot += (float)$detail->ot;
                                        } else {
                                            $total_m += (float)$detail->wm;
                                            $total_e += (float)$detail->we;
                                            $total_n += (float)$detail->wn;
                                            $total_b += (float)$detail->wb;
                                            $total_working += (float)$detail->working;
                                            $total_ot += (float)$detail->ot;
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
                                            {{ $detail->wm }}
                                        </td>
                                        <td style="text-align: center; font-size: 16px; padding: 0;">
                                            {{ $detail->we }}
                                        </td>
                                        <td style="text-align: center; font-size: 16px; padding: 0;">
                                            {{ $detail->wn }}
                                        </td>
                                        <td style="text-align: center; font-size: 16px; padding: 0;">
                                            {{ $detail->working }}
                                        </td>
                                        <td style="text-align: center; font-size: 16px; padding: 0;">
                                            {{ $detail->ot }}
                                        </td>
                                        <td style="text-align: center; font-size: 14px; padding: 0;">
                                            {{ $detail->remark }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr style="font-size: 16px;">
                                    <td style="text-align: center; padding: 0;" colspan="34">รวม</td>
                                    <td style="text-align: center; padding: 0;">
                                        {{ $total_m }}
                                    </td>
                                    <td style="text-align: center; padding: 0;">
                                        {{ $total_e }}
                                    </td>
                                    <td style="text-align: center; padding: 0;">
                                        {{ $total_n }}
                                    </td>
                                    <td style="text-align: center; padding: 0;">
                                        {{ $total_working }}
                                    </td>
                                    <td style="text-align: center; padding: 0;">
                                        {{ $total_ot }}
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- // Summary Sction -->
                    <?php
                        $total_en = $total_e + $total_n;

                        if ($schedule->schedule_type_id == '1') {
                            /** OT ของพยาบาล */
                            $net_ot = $total_ot * $ot_rn_rate;
                            /** ค่าเวรบ่าย-ดึก ของพยาบาล */
                            $net_en = $total_en * $en_rn_rate;
                        } else if ($schedule->schedule_type_id == '2') {
                            /** OT ของผู้ช่วยพยาบาล และ ผู้ช่วยเหลือคนไข้ */
                            $net_ot = ($total_ot * $ot_na_rate) + ($total_pn_ot * $ot_pn_rate);
                            /** ค่าเวรบ่าย-ดึก เฉพาะผู้ช่วยพยาบาล */
                            $total_pn_en = $total_pn_e + $total_pn_n;
                            $net_en = $total_pn_en * $en_pn_rate;
                        }

                        /** รวมเป็นเงินทั้งสิ้น */
                        $net_total = $net_ot + $net_en;
                    ?>
                    <tr>
                        <td colspan="6">
                            <div style="margin-top: 5px;">
                                <p style="margin: 0 50px;">
                                    หมายเหตุ : 
                                    @if ($schedule->schedule_type_id == '1')
                                        <span class="remark-text">
                                            จำนวนเงิน OT RN {{ $total_ot }}x{{ $ot_rn_rate }} = {{ number_format($net_ot, 2) }} บาท
                                        </span>
                                        <span class="remark-text" style="margin-left: 2rem;">
                                            ค่าตอบแทนบ่าย/ดึก RN  {{ $total_en }}x{{ $en_rn_rate }} = {{ number_format($net_en, 2) }} บาท
                                        </span>
                                    @elseif ($schedule->schedule_type_id == '2')
                                        <span class="remark-text">
                                            จำนวนเงิน OT PN {{ $total_pn_ot }}x{{ $ot_pn_rate }} = {{ number_format($total_pn_ot * $ot_pn_rate, 2) }} บาท
                                        </span>
                                        <span class="remark-text" style="margin-left: 2rem;">
                                            จำนวนเงิน OT NA  {{ $total_ot }}x{{ $ot_na_rate }} = {{ number_format($total_ot * $ot_na_rate, 2) }} บาท
                                        </span>
                                        <span class="remark-text" style="margin-left: 2rem;">
                                            ค่าตอบแทนบ่าย/ดึก PN  {{ $total_en }}x{{ $en_pn_rate }} = {{ number_format($net_en, 2) }} บาท
                                        </span>
                                    @endif
                                    <span class="remark-text" style="margin-left: 2rem;">{{ $schedule->remark }}</span>
                                </p>
                                <p style="margin: 0 50px;">
                                    รวมเป็นเงินทั้งสิ้น 
                                    <span class="remark-text" style="margin-left: 1rem;">{{ number_format($net_total, 2) }} บาท</span>
                                    <span class="remark-text" style="margin-left: 2rem;">( {{ baht_text($net_total) }} )</span>
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
                    <!-- // Signatures of head of depart and faction -->

                </table>
            </div>
        </div>
    </body>
</html>