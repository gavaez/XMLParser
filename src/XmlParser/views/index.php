<?php include 'header.php' ?>

<div class="center">
	<h2><?= $this->pageTitle ?></h2>
	<ul><h3>Task</h3>
		<li>Fork this repository:
			<a href="https://bitbucket.org/tundraint/php-technical-test">https://bitbucket.org/tundraint/php-technical-test</a>
		</li><li>Use the framework to create a page that displays the last image from the following feed:
			<a href="http://www.reddit.com/r/pics.xml">http://www.reddit.com/r/pics.xml</a>
		</li><li>Use best practices to demonstrate your capabilities. Be thorough, imagine the code will be deployed to a production environment. Include a fall-back in case the XML file can't be fetched.
		</li><li>Submit a pull request when you're done!</li>
	</ul>
	<hr>
		<?= $this->parsError?"<span class='error'> $this->parsError </span>":"XML parsing time: $this->performance secs."?>
</div>
<br>

<?
/*
 * Construct the html img tag excluding empty attributes
 */
if ((!$this->parsError) and ($this->src)){
		$imgHTML = "<img src=\"$this->src\"";
		if ($this->title) {
			$imgHTML .= " title=\"$this->title\"";
		}
		if ($this->alt) {
			$imgHTML .= " alt=\"$this->alt\"";
		}
		echo $imgHTML.'>';
	}
?>

<?php include 'footer.php' ?>
