<h1><?php echo html::specialchars($title) ?></h1>
<form class="recruit-tweets">
<input type="hidden" name="tweet1" class="endpoint" value="<?= url::site('/recruit/tweet') ?>" />
<textarea>I've raised $x from people who want to see me shave my head. Will you sponsor me too? http://bit.ly #b4tc</textarea>
<input type="submit" value="Tweet" />
</form>

<form class="recruit-tweets">
<input type="hidden" name="tweet1" class="endpoint" value="<?= url::site('/recruit/tweet') ?>" />
<textarea>Another Tweet template</textarea>
<input type="submit" value="Tweet" />
</form>

<form class="recruit-tweets">
<input type="hidden" name="tweet1" class="endpoint" value="<?= url::site('/recruit/tweet') ?>" />
<select>
   <option selected="selected">foo</option>
   <option>bar</option>
   <option>baz</option>
</select>
<textarea>@foo I challange you to join Bald for the Cure and raise money by shaving your head! #b4tc</textarea>
<input type="submit" value="Tweet" />
</form>