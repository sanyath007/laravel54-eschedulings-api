<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>ใบขออนุญาตเปลี่ยนเวร</title>
        <link rel="stylesheet" href="{{ asset('/css/pdf.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 style="margin: 0px;">ใบขออนุญาตเปลี่ยนเวร</h1>
            </div>
            <div class="content">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%; padding: 0;" colspan="3"></td>
                        <td style="text-align: right; padding: 0;" colspan="3">
                            <h4 style="margin: 0;">
                                ที่
                                <span style="margin: 0 50px 0 5px;">
                                    โรงพยาบาลเทพรัตน์นครราชสีมา
                                </span>
                            </h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0;" colspan="3"></td>
                        <td style="text-align: right; padding: 0;" colspan="3">
                            <h4 style="margin: 0;">
                                วันที่
                                <span style="margin: 0 50px 0 5px;">
                                    {{ convDbDateToLongThDate(date('Y-m-d')) }}
                                </span>
                            </h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <div>
                                <p style="margin-left: 60px;">
                                    ข้าพเจ้า <span style="border-bottom: 1px dotted black;">{{ $swapping->owner->person->prefix->prefix_name.$swapping->owner->person->person_firstname. ' ' .$swapping->owner->person->person_lastname }}</span>
                                    <span style="margin-left: 150px;">
                                        ตำแหน่ง <span>{{ $swapping->owner->person->position->position_name }}{{ $swapping->owner->person->academic ? $swapping->owner->person->academic->ac_name : '' }}</span>
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p style="margin-left: 60px;">
                                    ขออนุญาตเปลี่ยนเวร 
                                    <span style="margin: 0 10px;">(&nbsp;&nbsp;&nbsp;) เช้า</span>
                                    <span style="margin: 0 10px;">(&nbsp;&nbsp;&nbsp;) บ่าย</span>
                                    <span style="margin: 0 10px;">(&nbsp;&nbsp;&nbsp;) ดึก</span>
                                    <span style="margin: 0 10px;">(&nbsp;&nbsp;&nbsp;) BD</span>
                                    <span style="margin: 0 10px;">
                                        ของวันที่ <span>{{ convDbDateToLongThDate($swapping->owner_date) }}</span>
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p style="margin-left: 60px;">
                                    เหตุผลการขอเปลี่ยนเวร <span>{{ $swapping->reason }}</span>
                                    <span style="margin-left: 250px;">
                                        โดยมอบให้ <span>{{ $swapping->delegator->person->prefix->prefix_name.$swapping->delegator->person->person_firstname. ' ' .$swapping->delegator->person->person_lastname }}<</span>
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p style="margin-left: 60px;">
                                    ขึ้นปฏิบัติหน้าที่แทนข้าพเจ้า โดยข้าพเจ้าจะขึ้นปฏิบัติงาน
                                    <span style="margin-left: 10px;">
                                        ในวันที่ <span>{{ convDbDateToLongThDate($swapping->swap_date) }}</span>
                                    </span>
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="3">
                            <div style="margin-top: 20px;">
                                <p style="margin-left: 50px;">
                                    (ลงชื่อ)<span class="dot">......................................................</span>ผู้ขอเปลี่ยนเวร
                                </p>
                                <p style="margin-left: 100px;">
                                    (<span class="dot">{{ $swapping->owner->person->prefix->prefix_name.$swapping->owner->person->person_firstname. ' ' .$swapping->owner->person->person_lastname }}</span>)
                                </p>
                                <p style="margin-left: 50px;">
                                    ตำแหน่ง <span class="dot">{{ $swapping->owner->person->position->position_name }}{{ $swapping->owner->person->academic ? $swapping->owner->person->academic->ac_name : '' }}</span>
                                </p>
                            </div>
                            <div>
                                <p style="margin-left: 50px;">
                                    (ลงชื่อ)<span class="dot">......................................................</span>ผู้รับเปลี่ยนเวร
                                </p>
                                <p style="margin-left: 100px;">
                                    (<span class="dot">{{ $swapping->delegator->person->prefix->prefix_name.$swapping->delegator->person->person_firstname. ' ' .$swapping->delegator->person->person_lastname }}</span>)
                                </p>
                                <p style="margin-left: 50px;">
                                    ตำแหน่ง <span class="dot">{{ $swapping->delegator->person->position->position_name }}{{ $swapping->delegator->person->academic ? $swapping->delegator->person->academic->ac_name : '' }}</span>
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="margin-top: 20px;">
                                <p style="margin-left: 80px;">
                                    (ลงชื่อ)<span class="dot">......................................................</span>ผู้ควบคุม
                                </p>
                                <p style="margin-left: 120px;">
                                    (<span class="dot">{{ $controller->prefix->prefix_name.$controller->person_firstname. ' ' .$controller->person_lastname }}</span>)
                                </p>
                                <p style="margin-left: 80px;">
                                    ตำแหน่ง <span class="dot">{{ $controller->position->position_name }}{{ $controller->academic ? $controller->academic->ac_name : '' }}</span>
                                </p>
                            </div>
                        </td>
                        <td colspan="3">
                            <div style="margin-top: 20px;">
                                <p style="margin-left: 50px;">
                                    (ลงชื่อ)<span class="dot">......................................................</span>หัวหน้ากลุ่มงาน
                                </p>
                                <p style="margin-left: 100px;">
                                    (<span class="dot">{{ $headOfDepart->prefix->prefix_name.$headOfDepart->person_firstname. ' ' .$headOfDepart->person_lastname }}</span>)
                                </p>
                                <p style="margin-left: 50px;">
                                    ตำแหน่ง <span class="dot">{{ $headOfDepart->position->position_name }}{{ $headOfDepart->academic ? $headOfDepart->academic->ac_name : '' }}</span>
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <div style="margin-top: 10px;">
                                <p style="margin-left: 60px;">
                                    <span>หมายเหตุ : </span>
                                    <span>เป็นหน้าที่ของผู้เปลี่ยนเวรที่จะต้องรับผิดชอบกรณีไม่มีผู้ขึ้นเวรปฏิบัติงาน</span>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>