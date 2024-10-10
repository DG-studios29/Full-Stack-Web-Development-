<?php
function pageName($ss){
if ($ss === 'tos')
return 'Terms of Service';
else
return 'Privacy Policy';
}
?>
<html>
<head>
<title>{{pageName($subsection)}}</title>
</head>
<body>
<h1>Legal: {{pageName($subsection)}}</h1>
@if($subsection==='tos')
<p>You may not access non-public areas of the website.</p>
<!-- etc -->
@else
<p>Data collected by the website is not shared externally.</p>
<!-- etc -->
@endif
</body>
</html>