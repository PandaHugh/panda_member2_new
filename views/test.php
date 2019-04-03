<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<form id="testSuiteConfigurationform" name="testSuiteConfigurationform" method="post" class="ui-dform-form" novalidate="novalidate">
    <label class="ui-dform-label">
         <h3>Configuration Parameters</h3>

    </label>
    <div class="ui-dform-div inputDiv">
        <fieldset class="ui-dform-fieldset">
            <input type="text" id="totalRetryCount" name="totalRetryCount" tabindex="1" onblur="validateElement('Configuration', 'testSuiteConfigurationform','totalRetryCount')" class="ui-dform-text valid" />
            <legend class="ui-dform-legend">Total Retry Count</legend>
            <label for="totalRetryCount" class="checked">✔</label>
        </fieldset>
        <fieldset class="ui-dform-fieldset">
            <input type="text" id="totalRepeatCount" name="totalRepeatCount" tabindex="2" onblur="validateElement('Configuration', 'testSuiteConfigurationform','totalRepeatCount')" class="ui-dform-text" />
            <legend class="ui-dform-legend">Total Repeat Count</legend>
        </fieldset>
        <fieldset class="ui-dform-fieldset">
            <select id="summaryReportRequired" name="summaryReportRequired" tabindex="3" onblur="validateElement('Configuration', 'testSuiteConfigurationform','summaryReportRequired')" class="ui-dform-select">
                <option class="ui-dform-option" value="true">true</option>
                <option class="ui-dform-option" value="false">false</option>
            </select>
            <legend class="ui-dform-legend">Summary Report Required</legend>
        </fieldset>
        <fieldset class="ui-dform-fieldset">
            <select id="postConditionExecution" name="postConditionExecution" tabindex="4" onblur="validateElement('Configuration', 'testSuiteConfigurationform','postConditionExecution')" class="ui-dform-select">
                <option class="ui-dform-option" value="ALWAYS">ALWAYS</option>
                <option class="ui-dform-option" value="ON_SUCCESS">ON_SUCCESS</option>
            </select>
            <legend class="ui-dform-legend">Post Condition Execution</legend>
        </fieldset>
    </div>
</form>

<script type="text/javascript">
    // register jQuery extension
jQuery.extend(jQuery.expr[':'], {
    focusable: function (el, index, selector) {
        return $(el).is('a, button, :input, [tabindex]');
    }
});

$(document).on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(document.activeElement) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
</script>