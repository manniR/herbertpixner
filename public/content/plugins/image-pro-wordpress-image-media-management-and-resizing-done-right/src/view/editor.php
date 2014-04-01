<div id="impro-preview"></div>
<div id="impro_editor">

    <div class="impro-control-group">
        <label><?php _e('Image size preset', 'imagepro') ?></label>
        <select id="impro-editor-size">
            <optgroup label="Wordpress defined">
                <option value="__full"><?php _e('Full size', 'imagepro') ?></option>
                <?php
                $thumbnailSizes = @self::list_thumbnail_sizes();
                foreach($thumbnailSizes as $name => $attrs):
                    ?><option value="<?php echo addslashes($name) ?>" data-preset-width="<?php echo $attrs[0]?>" data-preset-height="<?php echo $attrs[1]?>"><?php echo ucfirst(htmlentities($name)) ?> (<?php echo $attrs[0]?>x<?php echo $attrs[1]?>)</option><?php
                endforeach;
                ?>
            </optgroup>
            <optgroup label="User defined">
                <option value="__custom" selected="selected"><?php _e('Custom size', 'imagepro') ?></option>
            </optgroup>
        </select>
    </div>

    <div class="impro-control-group">
        <label><?php _e('Manually change image size', 'imagepro') ?></label><br/>
        <input id="impro-editor-w" type="number" />
        <?php _e('width', 'imagepro') ?> x
        <input id="impro-editor-h" type="number" />
        <?php _e('height', 'imagepro') ?>
    </div>

    <div id="impro-editor-maxwidth-container">
        <label><input id="impro-editor-maxwidth" type="checkbox" /> <?php _e('Override size restriction', 'imagepro') ?></label>
        <br/>
        <div id="impro-editor-maxwidth-info">
<?php _e('The current WordPress theme allows images up to %maxwidth% pixels in width.<br/> Use the option above to disable this restriction for the current image. However, the image will not be responsive anymore.', 'imagepro') ?>
        </div>
    </div>

    <hr/>

	<label><?php _e('Align:', 'imagepro')?>
	<select class="impro_align">
		<option value="alignnone"><?php _e('None', 'imagepro')?></option>
		<option value="alignleft"><?php _e('Left', 'imagepro')?></option>
		<option value="aligncenter"><?php _e('Center', 'imagepro')?></option>
		<option value="alignright"><?php _e('Right', 'imagepro')?></option>
	</select>
	</label>
	
	<br/><br/>
	
	<label><input type="checkbox" class="impro_link" />
	<?php _e('Open the full picture on click', 'imagepro')?>	
	</label>

    <hr/>

    <label><?php _e('Alternative text:', 'imagepro')?>
        <input type="text" class="impro_alt" />
    </label>

    <label><?php _e('Title text:', 'imagepro')?>
        <input type="text" class="impro_title" />
    </label>

<div class="clear"></div>
</div>