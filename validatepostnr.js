<script type="text/javascript">
  function validatePostnum(form) {
    var x = parseInt(form.by.value);
	if (isNaN(x) || x < 1800) form.by.value = "1000";
	else
	if (x < 2000) form.by.value = "2000";
	else
	if (x > 2000 && x < 2500) form.by.value = "1000";
	else
	if (x > 5000 && x < 5280) form.by.value = "5000";
	else
	if (x > 6000 && x < 6020) form.by.value = "6000";
	else
	if (x > 6700 && x < 6720) form.by.value = "6700";
	else
	if (x > 7100 && x < 7130) form.by.value = "7100";
	else
	if (x > 8000 && x < 8220) form.by.value = "8000";
	else
	if (x == 8920 || x == 8930 || x == 8940 || x == 8960) form.by.value = "8900";
	else
	if (x > 9000 && x < 9230) form.by.value = "9000";
	else
	if (x > 9999) form.by.value = "1000";
  }
</script>

// <form onsubmit="validatePostnum(this)" action="index/danmark/byvejr_danmark.htm" class="broedtekst">
// Indtast postnummer <input type="text" class="broedtekst" name="by" id="by" size="8">
// </form>