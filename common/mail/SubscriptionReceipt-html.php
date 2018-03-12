<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>
<div class="password-reset">
    <h4>Subscription Successful!</h4>
</div>

<div class="invoice-box">
                <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Created: January 1, 2015<br>
                                <span>Next Payment:</span><?php echo $userpackagesubscription['next_payment']; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <span>User Name:</span><?php echo $user['username']; ?><br>
                                <span>Name:</span><?php echo $userdetails['Fname']; ?><?php echo $userdetails['Lname']; ?><br>
                            </td>
                            
                            <td>
                                <span>Address:</span><?php echo $userdetails['address1']; ?><br>
                                <?php echo $userdetails['address2']; ?><br>
                                <?php echo $userdetails['address3']; ?><br>
                                <span>Postcode:</span><?php echo $userdetails['postcode']; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Payment Method
                </td>
                
                <td>
                    Check #
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    Check
                </td>
                
                <td>
                    1000
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Item
                </td>
                
                <td>
                    Price(RM)
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    <span>Subscription:</span><?php echo $model['package']['type']; ?><br>
                    <span>Subscription Start:</span><?php echo $model['subscribe_time']; ?><br>
                    <span>Subscription End:</span><?php echo $model['end_period']; ?>
                </td>
                
                <td>
                    <span>RM</span><?php echo $model['package']['price']; ?>
                </td>
            </tr>
            
            <tr class="total">
                <td></td>
                
                <td>
                   <span>Total:<span><span>RM</span><?php echo $model['package']['price']; ?>
                </td>
            </tr>
        </table>	
</div>
