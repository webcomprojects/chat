@extends('admin.layout')
@section('title', 'نمایش قبض')
@section('actions')
    <a href="{{ route('infobills.index') }}" class="btn btn-primary btn-sm btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-arrow-right"></i>
        </span>
        <span class="text">برگشت</span>
    </a>
@endsection

{{-- @if ($record->status == 'confirm') --}}


@section('content')
    <style type="text/css">


        .ritz .waffle a {
            color: inherit;
        }

        .ritz .waffle .s7 {
            border-bottom: 2px SOLID #000000;
            border-left: 2px SOLID #000000;
            background-color: #96b0de;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 14pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s18 {
            border-bottom: 1px SOLID #000000;
            border-left: 1px SOLID #000000;
            background-color: #ffff00;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 13pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s8 {
            border-bottom: 1px SOLID #000000;
            background-color: #ffffff;
        }

        .ritz .waffle .s17 {
            border-bottom: 1px SOLID #000000;
            border-left: 1px SOLID #000000;
            background-color: #ffff00;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 14pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s20 {
            border-bottom: 2px SOLID #000000;
            border-left: 1px SOLID #000000;
            background-color: #ffff00;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 12pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s2 {
            border-left: 1px SOLID #000000;
            background-color: #ffffff;
        }

        .ritz .waffle .s4 {
            border-left: 2px SOLID #000000;
            background-color: #ffffff;
        }

        .ritz .waffle .s13 {
            border-bottom: 2px SOLID #000000;
            border-left: 2px SOLID #000000;
            background-color: #96b0de;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 14pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s11 {
            border-bottom: 1px SOLID #000000;
            border-left: 1px SOLID #000000;
            background-color: #fbe4d5;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 13pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s5 {
            border-bottom: 2px SOLID #000000;
            border-left: 2px SOLID #000000;
            background-color: #96b0de;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 14pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s10 {
            border-bottom: 2px SOLID #000000;
            border-left: 1px SOLID #000000;
            background-color: #fbe4d5;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 13pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s12 {
            border-bottom: 1px SOLID #000000;
            border-left: 2px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            font-weight: bold;
            color: #000000;

            font-size: 13pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s19 {
            border-bottom: 1px SOLID #000000;
            border-left: 1px SOLID #000000;
            background-color: #ffff00;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 12pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s14 {
            border-bottom: 1px SOLID #000000;
            border-left: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 12pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s16 {
            border-bottom: 1px SOLID #000000;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffff00;
            text-align: right;
            font-weight: bold;
            color: #000000;

            font-size: 13pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s9 {
            border-bottom: 1px SOLID #000000;
            border-left: 1px SOLID #000000;
            background-color: #fbe4d5;
            text-align: right;
            font-weight: bold;
            color: #000000;
            border-right: 1px SOLID #000000;
            font-size: 13pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s1 {
            border-bottom: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            font-weight: bold;
            color: #000000;

            font-size: 12pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s0 {
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s15 {
            border-bottom: 1px SOLID #000000;
            border-left: 2px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 12pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s3 {
            border-bottom: 2px SOLID #000000;
            border-left: 1px SOLID #000000;
            background-color: #fbe4d5;
            text-align: right;
            font-weight: bold;
            color: #000000;

            font-size: 13pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: rtl;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s6 {
            border-bottom: 2px SOLID #000000;
            border-left: 2px SOLID #000000;
            background-color: #ff6565;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 16pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s21 {
            border-bottom: 2px SOLID #000000;
            border-left: 2px SOLID #000000;
            background-color: #ff9900;
            text-align: center;
            font-weight: bold;
            color: #000000;

            font-size: 14pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .row-headers-background,
        .header-table {
            visibility: hidden;
        }
    </style>
    <div class="ritz grid-container" dir="rtl">
        <table class="waffle no-grid" cellspacing="0" cellpadding="0">
            <thead class="header-table">
                <tr>
                    <th class="row-header freezebar-origin-rtl"></th>
                    <th id="1669493699C0" style="width:171px;" class="column-headers-background">A</th>
                    <th id="1669493699C1" style="width:142px;" class="column-headers-background">B</th>
                    <th id="1669493699C2" style="width:143px;" class="column-headers-background">C</th>
                    <th id="1669493699C3" style="width:195px;" class="column-headers-background">D</th>
                    <th id="1669493699C4" style="width:159px;" class="column-headers-background">E</th>
                    <th id="1669493699C5" style="width:143px;" class="column-headers-background">F</th>
                    <th id="1669493699C6" style="width:157px;" class="column-headers-background">G</th>
                    <th id="1669493699C7" style="width:150px;" class="column-headers-background">H</th>
                    <th id="1669493699C8" style="width:155px;" class="column-headers-background">I</th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 18px">
                    <th id="1669493699R1" style="height: 18px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 18px">2</div>
                    </th>
                    <td class="s0"></td>
                    <td class="s1" colspan="3"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 51px">
                    <th id="1669493699R2" style="height: 51px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 51px">3</div>
                    </th>
                    <td class="s2"></td>
                    <td class="s3" dir="rtl">آیا مشمول ماده 16 <br>می شوید</td>
                    <td class="s3" dir="rtl">میزان خرید برق دوجانبه (کیلوواتساعت)</td>
                    <td class="s3" dir="rtl">نرخ خرید برق دوجانبه (ریال)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 18px">
                    <th id="1669493699R3" style="height: 18px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 18px">4</div>
                    </th>
                    <td class="s4"></td>
                    <td class="s5" dir="rtl">{{ $record->made16_status == 'yes' ? 'بله' : 'نه' }}</td>
                    <td class="s6"> 900,000 </td>
                    <td class="s7"> {{ number_format($record->Two_way_electricity_rate) }} </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 30px">
                    <th id="1669493699R4" style="height: 30px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 30px">5</div>
                    </th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="height: 30px">
                    <th id="1669493699R5" style="height: 30px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 30px">6</div>
                    </th>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                </tr>
                <tr style="height: 82px">
                    <th id="1669493699R7" style="height: 82px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 82px">8</div>
                    </th>
                    <td class="s9" dir="rtl">شرح مصارف </td>
                    <td class="s10" dir="rtl">مصرف کنتور <br>(کیلوواتساعت)</td>
                    <td class="s10" dir="rtl">ضریب تخصیص بار پایه (Tou) <span
                            style="font-size:14pt;font-weight:bold;color:#000000;">*</span>
                    </td>
                    <td class="s11" dir="rtl">میزان مشمول ماده 16<br>جهش تولید صنایع دانش بنیان
                        (کیلوواتساعت)
                    </td>
                    <td class="s11" dir="rtl">میزان مصرف غیر مشمول<br> (کیلوواتساعت)</td>
                    <td class="s11" dir="rtl">مصرف دوجانبه و بورس<br>(کیلوواتساعت)</td>
                    <td class="s10" dir="rtl">نرخ تأمین برق پشتیبان<br> در آخرین قبض موجود (ریال به
                        کیلوواتساعت)</td>
                    <td class="s11" dir="rtl">هزینه خرید برق دوجانبه<br>(ریال)</td>
                    <td class="s11" dir="rtl">هزینه خرید برق پشتیبان<br>(ریال)</td>
                </tr>
                <tr style="height: 18px">
                    <th id="1669493699R8" style="height: 18px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 18px">9</div>
                    </th>
                    <td class="s12" dir="rtl">میان باری </td>
                    <td class="s13"> {{ number_format($record->middle_load_meter_consumption) }} </td>
                    <td class="s13"> {{ $record->middle_load_allocation_coefficient }} </td>
                    <td class="s14" dir="rtl">
                        {{ number_format(($included * $record->middle_load_meter_consumption) / 100) }}</td>
                    <td class="s14" dir="rtl">
                        {{ number_format(($not_included * $record->middle_load_meter_consumption) / 100) }}</td>
                    <td class="s15" dir="rtl">412,500</td>
                    <td class="s13"> {{ number_format($record->middle_load_electricity_supply_rate) }} </td>
                    <td class="s14" dir="rtl"></td>
                    <td class="s14" dir="rtl">0</td>
                </tr>
                <tr style="height: 18px">
                    <th id="1669493699R9" style="height: 18px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 18px">10</div>
                    </th>
                    <td class="s12" dir="rtl">اوج بار </td>
                    <td class="s13"> {{ number_format($record->peak_load_meter_consumption) }} </td>
                    <td class="s13"> {{ $record->peak_load_allocation_coefficient }} </td>
                    <td class="s14" dir="rtl">
                        {{ number_format(($included * $record->peak_load_meter_consumption) / 100) }}</td>
                    <td class="s14" dir="rtl">
                        {{ number_format(($not_included * $record->peak_load_meter_consumption) / 100) }}</td>
                    <td class="s15" dir="rtl">225,000</td>
                    <td class="s13"> {{ number_format($record->peak_load_electricity_supply_rate) }} </td>
                    <td class="s14" dir="rtl"></td>
                    <td class="s14" dir="rtl">0</td>
                </tr>
                <tr style="height: 18px">
                    <th id="1669493699R10" style="height: 18px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 18px">11</div>
                    </th>
                    <td class="s12" dir="rtl">کم باری</td>
                    <td class="s13"> {{ number_format($record->low_load_meter_consumption) }} </td>
                    <td class="s13"> {{ $record->low_load_allocation_coefficient }} </td>
                    <td class="s14" dir="rtl">
                        {{ number_format(($included * $record->low_load_meter_consumption) / 100) }}</td>
                    <td class="s14" dir="rtl">
                        {{ number_format(($not_included * $record->low_load_meter_consumption) / 100) }}</td>
                    <td class="s15" dir="rtl">262,500</td>
                    <td class="s13"> {{ number_format($record->low_load_electricity_supply_rate) }} </td>
                    <td class="s14" dir="rtl"></td>
                    <td class="s14" dir="rtl">88,483,500</td>
                </tr>
                <tr style="height: 18px">
                    <th id="1669493699R11" style="height: 18px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 18px">12</div>
                    </th>
                    <td class="s16" dir="rtl">جمع</td>
                    <td class="s17">
                        {{ $record->low_load_meter_consumption + $record->middle_load_meter_consumption + $record->peak_load_meter_consumption }}
                    </td>
                    <td class="s17">
                        {{ $record->middle_load_allocation_coefficient + $record->peak_load_allocation_coefficient + $record->low_load_allocation_coefficient }}
                    </td>
                    <td class="s18">
                        {{ number_format(($included * $record->middle_load_meter_consumption) / 100 + ($included * $record->peak_load_meter_consumption) / 100 + ($included * $record->low_load_meter_consumption) / 100) }}
                    </td>
                    <td class="s18">
                        {{ number_format(($not_included * $record->middle_load_meter_consumption) / 100 + ($not_included * $record->peak_load_meter_consumption) / 100 + ($not_included * $record->low_load_meter_consumption) / 100) }}
                    </td>
                    <td class="s19" dir="rtl">900,000</td>
                    <td class="s19" dir="rtl"></td>
                    <td class="s20" dir="rtl">1,035,000,000</td>
                    <td class="s20" dir="rtl">88,483,500</td>
                </tr>
                <tr style="height: 39px">
                    <th id="1669493699R12" style="height: 39px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 39px">13</div>
                    </th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="s4"></td>
                    <td class="s21" colspan="2">1,123,483,500</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

{{-- @else
    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    قبض شما {!! $record->status !!} است و قابل مشاهده نیست!
                </div>
            </div>
        </div>
    @endsection
@endif --}}
