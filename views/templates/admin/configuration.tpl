{if $message != null}
    <div class="alert alert-success" role="alert">
        <p class="alert-text">
            {$message}
        </p>
    </div>
{/if}


<form action="" method="post">
    <div class="form-group">
        <label class="form-control-label" for="input1">Normal input</label>
        <input type="text" name="courserating" value="{$courserating}" class="form-control" id="input1" required />
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Primary</button>
    </div>
</form>