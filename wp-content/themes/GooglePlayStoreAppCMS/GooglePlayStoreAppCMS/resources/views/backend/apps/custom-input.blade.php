<h5>Custom Inputs | <small> Add custom inputs and additonal informations for your app</small></h5>
<hr/>
<div class="card">
    <div class="card-block">
        
        <fieldset class="form-group">
            <label for="description">
            Required Android
            </label>
            <input type="text" ng-model="details.required_android" class="form-control" placeholder="Enter required android"/>
        </fieldset>
        <fieldset class="form-group">
            <label for="description">
            Total Install
            </label>
            <input type="text" ng-model="details.installs" class="form-control" placeholder="Enter number of install devices"/>
        </fieldset>

        <fieldset class="form-group">
            <label for="description">
            App Ratings
            </label>
            <input type="text" ng-model="details.ratings" class="form-control" placeholder="Enter app raitings"/>
        </fieldset>

        <fieldset class="form-group">
            <label for="description">
            Ratings Total
            </label>
            <input type="text" ng-model="details.ratings_total" class="form-control" placeholder="Enter raitings total"/>
        </fieldset>

        <fieldset class="form-group">
            <label for="description">
            Published Date
            </label>
            <input type="text" ng-model="details.published_date" class="form-control" placeholder="Enter published date"/>
        </fieldset>

        <hr/>

    	<fieldset class="form-group">
		    <label for="google-playlink">
		      Create Custom Input Fields
		    </label>

		    <button type="button" class="btn btn-sm btn-default" 
        	ng-click="addCustomOptions()">Add Options
      		</button>

		    <div ng-repeat="option in details.custom track by $index">
		    	<select ng-model=option.identifier>
			        <option ng-repeat="type in inputTypes">@{{ type }}</option>
			    </select>
		        <label>Key Name<small>Ex. Additional Requirements</small></label>
		        <input type="text" ng-model="option.key" class="form-control" placeholder="Enter your key name"/>
		        <label>Value</label>
		        <input ng-if="option.identifier == 'text'" type="text" class="form-control" placeholder="Enter your value" ng-model="option.value">
		    	<textarea ng-if="option.identifier == 'textarea'" class="form-control" placeholder="Enter your details" rows="6" ui-tinymce="tinymceOptions" ng-model="option.value"></textarea>
		    	<hr/>
		    </div>
		</fieldset>

    </div>
</div>