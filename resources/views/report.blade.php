<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clinic Inventory Report</title>

    <style>
        table{
            border-collapse: collapse;
            width: 100%;
            
        }
        th{
            border-bottom: 1px solid black;
        }
        th,td{
            padding: 5px;
            text-align: center;
            font-family: sans-serif;
        }
        th{
            font-size: 16px;
        }
        td{
            font-size: 13px;
            color: #302f2f;
        }
        .header,
        .footer {
            width: 100%;
            position: fixed;
        }
        .header {
            top: 0px;
        }
        .img-left{
            position: absolute;
            top: -10;
            left: 30;
        }
        .img-right{
            position: absolute;
            top: -10;
            right: 30;
        }
        .tcgc,.ihs{
            font-weight: bold;
        }
        .tcgc{
            margin-bottom: 10px;
        }
        .institute{
            margin-top: 1.6rem;
            margin-bottom: 1rem;
            font-weight: bold;
            font-size: 25px;
            color: #000;
        }
        .program{
            color: #22753e;
            font-size: 17px;
        }
        .footer {
            bottom: 2rem;
        }
        .footer-bg{
            background: #22753e;
            position: relative;
            height: 2.5rem;
            width: 100%;
           
        }
        .luxmundi{
            position: absolute;
            top: 50%;
            left: 50%;
            
            transform: translate(-50%, -50%);
        }
        .luxmundi_left{
            text-align: center;
            color: white;
            width: 30%;
            margin-left: 50px;
            padding-top: 5px;
            font-size: 13px;
            font-weight: bold;
        }
        .luxmundi img{
            border-radius: 50%;
        }
        .luxmundi_right{
            position: absolute;
            top: 0;
            right: 0;
            font-size: 14px;
            margin-top: 10px;
            color: white;
        }
        .abbr{
            font-weight: bold;
            font-size: 18px;
            margin-left: 4px;
        }
        .header-content{
            text-align: center;
        }
        .content{
            margin-top: 8rem;
        }
        .date{
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div id="bg"></div>
    <div class="header">
        <div class="header-content">
            <div class="img-left">
                <img src="images/logo.jpg" class="bg" width="70" height="70">
            </div>
            <div class="center">
                <div class="tcgc">TANGUB CITY GLOBAL COLLEGE</div>
                <div class="ihs">MEDICAL DENTAL CLINIC</div>
            </div>
            <div class="img-right">
                <img src="images/iom.png" class="bg" width="70" height="70">
            </div>
            
            <div class="institute">Clinic Inventory Report</div>
        </div>
        
    </div>
    
    <div class="content">
        <div class="date">
            <div><b>From:</b> {{Carbon\Carbon::parse($date_from)->format('F d Y')}}</div>
            <div><b>To:</b> {{Carbon\Carbon::parse($date_to)->format('F d Y')}}</div>
        </div>

        <table>
            <thead>
               <tr>
                    <th>General Description</th>
                    <th>Total Added</th>
                    <th>Total Deducted</th>
                    <th>Onhand</th>
               </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{$transaction->general_description}}</td>
                        <td>{{$transaction->total_added}}</td>
                        <td>{{$transaction->total_deducted}}</td>
                        <td>{{$transaction->total_onhand}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>