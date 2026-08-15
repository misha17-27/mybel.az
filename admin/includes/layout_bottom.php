    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /admin -->
<script>
(function(){
  var b=document.getElementById('menuBtn'),s=document.getElementById('sidebar'),bd=document.getElementById('backdrop');
  function toggle(){s.classList.toggle('open');bd.classList.toggle('show')}
  if(b)b.addEventListener('click',toggle);
  if(bd)bd.addEventListener('click',toggle);
  // silmə təsdiqi
  document.querySelectorAll('form[data-confirm]').forEach(function(f){
    f.addEventListener('submit',function(e){ if(!confirm(f.getAttribute('data-confirm')))e.preventDefault(); });
  });
})();
</script>
</body>
</html>
