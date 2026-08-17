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

  // Vizual redaktor (Quill) — textarea.richtext sahələri üçün
  if (window.Quill) {
    document.querySelectorAll('textarea.richtext').forEach(function(ta){
      var box = document.createElement('div');
      box.className = 'rt-editor';
      ta.style.display = 'none';
      ta.parentNode.insertBefore(box, ta.nextSibling);
      var q = new Quill(box, { theme: 'snow', modules: { toolbar: [
        [{ header: [2, 3, false] }],
        ['bold', 'italic', 'underline'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['blockquote', 'link'],
        ['clean']
      ] } });
      q.root.innerHTML = ta.value;
      var form = ta.closest('form');
      if (form) form.addEventListener('submit', function(){ ta.value = q.root.innerHTML; });
    });
  }
})();
</script>
</body>
</html>
