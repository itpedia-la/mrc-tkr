@if( Auth::id() ) 
<hr style="margin:50px 0px 0px 0px"/><p style="color:#666;  font-size:10px" align="center">Copyright &copy; 2015 - Bob Freeman Talk Show | Developed by: IT Pedia Sole.,Ltd (+856 20 5999 8848)</p> 
@else
<p style="color:#666; margin-top:50px; line-height:2em; font-size:10px" align="center">Copyright &copy; 2015 - Bob Freeman Talk Show <br/> Developed by: IT Pedia Sole.,Ltd (+856 20 5999 8848)</p>
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