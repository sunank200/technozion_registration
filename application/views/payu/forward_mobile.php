<?php
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
$hashVarsSeq = explode('|', $hashSequence);
$hash_string = '';
foreach($hashVarsSeq as $hash_var) {
    $hash_string .= isset($payu[$hash_var]) ? $payu[$hash_var] : '';
    $hash_string .= '|';
}
$hash_string .= $payu['salt'];
$payu['hash'] = strtolower(hash('sha512', $hash_string));
echo json_encode($payu);
?>
<!--
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <p><center>Redirecting to you Payu...</center></p>
        <form action="<?php echo $payu['action']; ?>" method="POST" name="payuForm">
            <input type="hidden" name="key" value="<?php echo $payu['key']; ?>" />
            <input type="hidden" name="hash" value="<?php echo $payu['hash']; ?>"/>
            <input type="hidden" name="txnid" value="<?php echo $payu['txnid']; ?>" />
            <input type="hidden" name="amount" value="<?php echo $payu['amount']; ?>">
            <input type="hidden" name="productinfo" value="<?php echo $payu['productinfo']; ?>">
            <input type="hidden" name="firstname" value="<?php echo $payu['firstname']; ?>">
            <input type="hidden" name="email" value="<?php echo $payu['email']; ?>">
            <input type="hidden" name="phone" value="<?php echo $payu['phone']; ?>">
            <input type="hidden" name="surl" value="<?php echo $payu['surl']; ?>">
            <input type="hidden" name="curl" value="<?php echo $payu['curl']; ?>">
            <input type="hidden" name="furl" value="<?php echo $payu['furl']; ?>">
            <input type="hidden" name="tourl" value="<?php echo $payu['tourl']; ?>">
            <input type="hidden" name="drop_category" value="<?php echo $payu['drop_category']; ?>">
            <input type="hidden" name="drop_category" value="<?php echo $payu['drop_category']; ?>">
        </form>
        <script>
        var payuForm = document.forms.payuForm;
        payuForm.submit();
        </script>
    </body>
</html>-->