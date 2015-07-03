<div class="wrap">

    <h2>Migration</h2>

    <? if ($migrationDone) :?>
        <div class="updated">
            <p>
                <?=__("Migration done", "webqam")?>
            </p>
        </div>
    <? endif ?>

    <form action="#" method="post">

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="blogname"><?=__("Old URL", "webqam");?></label></th>
                    <td><input name="wp_em_oldurl" type="text" value="" class="regular-text"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="blogname"><?=__("New URL", "webqam");?></label></th>
                    <td><input name="wp_em_newurl" type="text" value="<?=get_option("siteurl")?>" class="regular-text"></td>
                </tr>
            </tbody>
        </table>

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?=__("Do migration", "webqam")?>">
        </p>

    </form>

</div>