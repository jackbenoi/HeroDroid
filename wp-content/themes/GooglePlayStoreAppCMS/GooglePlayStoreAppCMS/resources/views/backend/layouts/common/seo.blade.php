<div class="panel panel-default">
    <div class="panel-body clearfix">
    	<h5>SEO Options | <small>Optimize Your Page rank</small></h5>
    	<hr/>
		<div class="form-group ">
		    <label for="title">SEO Title</label>
		    <input type="text" ng-model="details.seo_title" class="form-control" id="seo_title" placeholder="Seo Title">
		</div>

		<div class="form-group ">
		    <label for="descriptions">SEO Meta Descriptions</label>
		    <textarea maxlength="160" class="form-control" rows="3" ng-model="details.seo_descriptions" placeholder="160 Max Characters Only"></textarea>
		    <p class="text-right text-danger">@{{ 160 - details.seo_descriptions.length }} characters left!</p>
		</div>

		 <div class="form-group ">
		    <label for="descriptions">SEO Meta Keywords <small>(comma separated)</small></label>
		    <tags-input ng-model="details.seo_keywords" placeholder="Add New Keywords">
		    </tags-input>
		</div>
    </div>
</div>