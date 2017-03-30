<?php

$git_not_found = empty(exec("git"));

$repo_url = exec("git remote get-url origin");

$rev_num = str_pad(exec("git rev-list HEAD | wc -l"), 4, "0", STR_PAD_LEFT);

$hash_short = exec("git log --pretty=%h -n1 HEAD");
$hash_long = exec("git log --pretty=%H -n1 HEAD");

$rev_date = exec("git log --pretty=%ci -n1 HEAD");

$last_rev = "<a target=_blank href='";

if(strpos($repo_url, "github.com") !== false)
{
    $last_rev .= str_replace(".git", "/commit/", $repo_url);
    $last_rev .= "$hash_long'>$hash_short</a>";
}

else if(strpos($repo_url, "bitbucket.org") !== false)
{
    $last_rev .= str_replace(".git", "/commits/", $repo_url);
    $last_rev = preg_replace("/(?<=https:\\/\\/).+@(?=bitbucket)/", "", $last_rev);
    $last_rev .= "$hash_long'>$hash_short</a>";
}

else
    $last_rev = $hash_short;