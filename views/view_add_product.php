<h2>Добавить товар</h2>
<form action="/product/add" enctype="multipart/form-data" method="post" class="form">
    <input type="file" name = 'my_file'>
    <p>Укажите автора</p>
    <input type="text" name = 'name' size="38">
    <p>Описание</p>
    <p><textarea name="description" cols="40" rows="4"></textarea></p>
    <p>Цена</p>
    <input type="number" name = 'price' size="38" step="0.01">
    <input type="submit">
</form>



