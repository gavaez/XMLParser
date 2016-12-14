<? include __DIR__ . 'header.php' ?>

<div class="center">
    <h2><?= $this->pageTitle ?></h2>
    <h3>Task</h3>
    <ul>
        <li>
            Fork this repository:
            <a href="<?= $href = 'https://bitbucket.org/tundraint/php-technical-test' ?>"><?= $href ?></a>
        <li>
            Use the framework to create a page that displays the last image from the following feed:
            <a href="<?= $href = 'http://www.reddit.com/r/pics.xml' ?>"><?= $href ?></a>
        <li>
            Use best practices to demonstrate your capabilities.
            Be thorough, imagine the code will be deployed to a production environment.
            Include a fall-back in case the XML file can't be fetched.
        <li>
            Submit a pull request when you're done!
    </ul>
    <hr>
<? if ($this->parsError) : ?>
    <span class="error"><?= $this->parsError ?></span>
<? else : ?>
    XML parsing time: <?= $this->performance ?> secs.
<? endif ?>
</div>

<?
    /**
     * Construct the html img tag excluding empty attributes
     */
    if (!$this->parsError && ($image = $this->image)) {
        $attributes = array_map(function ($attr) use ($image) {
            return ($value = $image->$attr) ? "$attr=\"$value\"" : false;
        }, ['src', 'title', 'alt']);

        echo '<br><img ', implode(' ', array_filter($attributes)), '>';
    }
?>

<? include __DIR__ . 'footer.php' ?>
