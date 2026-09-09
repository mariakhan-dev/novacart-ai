<form id="jazzcash_form" method="POST" action="https://sandbox.jazzcash.com.pk/ApplicationAPI/API/2.0/Purchase/DoMWalletTransaction">
    <input type="hidden" name="pp_Version" value="2.0">
    <input type="hidden" name="pp_TxnType" value="MPAY">
    <input type="hidden" name="pp_Language" value="EN">
    <input type="hidden" name="pp_MerchantID" value="{{ $pp_MerchantID }}">
    <input type="hidden" name="pp_SubMerchantID" value="">
    <input type="hidden" name="pp_Password" value="{{ $pp_Password }}">
    <input type="hidden" name="pp_BankID" value="TBANK">
    <input type="hidden" name="pp_ProductID" value="RETL">
    <input type="hidden" name="pp_TxnRefNo" value="{{ $pp_TxnRefNo }}">
    <input type="hidden" name="pp_Amount" value="{{ $pp_Amount }}">
    <input type="hidden" name="pp_TxnCurrency" value="PKR">
    <input type="hidden" name="pp_TxnDateTime" value="{{ $pp_TxnDateTime }}">
    <input type="hidden" name="pp_BillReference" value="{{ $pp_BillReference }}">
    <input type="hidden" name="pp_Description" value="Order Payment">
    <input type="hidden" name="pp_SecureHash" value="{{ $pp_SecureHashValue }}">
    <input type="hidden" name="pp_ReturnURL" value="{{ $pp_ReturnURL }}">
</form>
<script>document.getElementById('jazzcash_form').submit();</script>