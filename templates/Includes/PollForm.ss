<%-- The actual resulting form is rendered here. --%>
<h2>$poll.Question</h2>
<% if $getShouldShowResults %>
	<ul>
                <% loop $poll.Answers %>
		<li class="poll-answer" title="{$Percentage(2)}%"><div class="poll-answer__name">$Title</div>
			<div class="poll-answer-bar" <% if $Percentage %>style="background: linear-gradient(to right, rgb(102,197,229) 0%, rgb(102,197,229) {$Percentage}%, rgb(244,247,249) $Percentage(1)%)"<% end_if %>>&nbsp;</div></li>
		<% end_loop %>
	</ul>
<% else %>
	$DefaultForm
<% end_if %>