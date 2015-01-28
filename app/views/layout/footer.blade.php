@if( Auth::id() ) 
<hr style="margin:50px 0px 0px 0px"/><p style="color:#666;  font-size:10px" align="center">Copyright &copy; 2015 - Bob Freeman Talk Show | Developed by: <a href="http://www.itpedia.la" target="_blank">IT Pedia Sole., Ltd</a></p> 
@else
<p style="color:#666; margin-top:50px; line-height:2em; font-size:10px" align="center">Copyright &copy; 2015 - Bob Freeman Talk Show <br/> Developed by: <a href="http://www.itpedia.la" target="_blank">IT Pedia Sole., Ltd</a></p>
@endif
</div>

<script>
	$(document).ready(function() {
		// Main Menu
		$("#menu").kendoMenu();
		
	});
</script>
</body>
</html>