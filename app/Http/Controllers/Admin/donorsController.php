<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class donorsController extends Controller
{
    //
    public function print_form(Request $request,$cpr){


        $donor=Donor::where('cpr',$cpr)->first();
//        return dd($donor);

        echo "";

        {

            if(isset($donor))
            {
                $thename = $donor->name;
                $mobile = $donor->phone;


                ?>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

                <center>
                    <h1>حملة الرسول الأعظم (ص) للتبرع بالدم 14</h1>

                </center>

                <BR>

                <div class="container">
                    <table class="table" style="font-size:10px;">
                        <tbody>
                        <tr>
                            <td colspan=2>
                                <?php
                                echo "<div><span style=\"font-size:12px;\"><STRONG>CPR NUMBER: ".$cpr."</STRONG></span></div>";
                                ?>
                            </td>
                            <td>Mobile Number: <?php echo $mobile; ?></td>
                        </tr>
                        <tr>
                            <td colspan=3>
                                <?php
                                echo "<div><span style=\"font-size:12px;\"><STRONG>NAME : ".$thename."</STRONG></span></div>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Date of Birth: </td>
                            <td></td>
                            <td>Gender: ذكر</td>
                        </tr>
                        </tbody>
                    </table>
                    <BR>
                    <STRONG style="font-size:12px;">Physical Examiation</STRONG>
                    <div class="well" style="background-color: white;">
                        <table  class="table" style="font-size:10px;">
                            <tbody>
                            <tr>
                                <td style=" border: none;">Weight: </td>
                                <td style=" border: none;">BP:</td>
                                <td style=" border: none;text-align: center;">Pulse Rate:</td>
                            </tr>
                            <tr>
                                <td style=" border: none;text-align: right;">Fit to donate</td>
                                <td style=" border: none;text-align: center;">Yes</td>
                                <td style=" border: none;">No</td>
                            </tr>
                            <tr style="padding:0px;">
                                <td colspan=3 style="padding:0px;"><center>Staff intial:</center></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <STRONG style="font-size:12px;">Hb & BG</STRONG>
                    <div class="well" style="background-color: white;">
                        <table  class="table" style="font-size:10px;">
                            <tbody>
                            <tr>
                                <td style=" border: none;">BG: </td>
                                <td style=" border: none;">Hb:</td>
                                <td style=" border: none;"></td>
                            </tr>
                            <tr>
                                <td style=" border: none;text-align: center;">Fit to donate</td>
                                <td style=" border: none;">Yes</td>
                                <td style=" border: none;">No</td>
                            </tr>
                            <tr>
                                <td style=" border: none;text-align: center;">Rapid Test</td>
                                <td style=" border: none;">Positive</td>
                                <td style=" border: none;">Negetive</td>
                            </tr>
                            <tr style="padding:0px;">
                                <td colspan=3 style="padding:0px;"><center>Staff intial:</center></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <STRONG style="font-size:12px;">BAG Preparation</STRONG>
                    <div class="well" style="background-color: white;">
                        <table  class="table" style="font-size:10px;">
                            <tbody>
                            <tr>
                                <td style=" border: none;">Donor No.: </td>
                                <td style=" border: none;">Tag No.:</td>
                                <td style=" border: none;"></td>
                            </tr style="padding:0px;">
                            <td colspan=3 style="padding:0px;"><center>Staff intial:</center></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <br/><br/>
                </div>




                <?php
                echo "";
                echo "<center><input type=\"submit\" onclick=\"window.print()\" class=\"btn-lg btn-success hidden-print\" value=\"طباعة البيانات\"><BR><BR>";
                echo "";
            }
            else
            {
                echo "error occured";
            }

        }

    }
}
