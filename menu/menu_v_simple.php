<script language="javascript">
<!--        
function clickshow(num) {
    for (i=1; i<4; i++) {
        menu=eval("document.all.block"+i+".style");
        imgch=eval("document.all.bar"+i);
        if (num==i) {
            if (menu.display=="block") {
                menu.display="none"; 
                imgch.innerHTML="■";
            }
            else {
                menu.display="block"; 
                imgch.innerHTML="▼";
            }
        }
    }
}
//-->
</script>

<style>
.mn11 {border-top:1 solid #336699; background:#336699; padding:7 5 4 5; color:white; cursor:hand}
.mn12 {border-top:1 solid #336699; background:#99ccff; padding:7 5 4 5; color:blue; cursor:hand}
.mn21 {border-bottom:1 solid beige; background:beige; padding:3 5; cursor:hand}
.mn22 {border-bottom:1 solid #336699; background:#99ccff; padding:3 5; cursor:hand}
</style>
