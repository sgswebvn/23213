<textarea id="editor" class="addcmt" required></textarea><br /><br />
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
  ClassicEditor.create(document.querySelector("#editor")).catch((error) => {
    console.error(error);
  });
</script>
