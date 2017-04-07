<?php

class advancedPostLister extends Plugin {

    public function init() {
        // make $APL object available in themes
        global $APL;
        $APL = $this;
    }


    // returns a list of posts filtered by a list of tags
    public function getPostsByTagList($tagList=false) {

        // get all posts
        global $dbPosts;
        $totalPublishedPosts = $dbPosts->numberPost(true);
        $posts = buildPostsForPage(0, $totalPublishedPosts, true, false);

        // do we need to Filter?
        if ($tagList) {
            // build a list of filtered posts
            $filteredPosts = [];
            foreach ($posts as $Post) {
                $addPost = false;
                foreach($tagList as $tag) {
                    if ( strpos(strtolower($Post->tags()), strtolower($tag)) !== false ) {
                        $addPost = true;
                    }
                }
                if ( $addPost ) {
                    $filteredPosts[] = $Post;
                }
            }
        } else {
            $filteredPosts = $posts;
        }

        return $filteredPosts;
    }

    // redudant ....
    public function getPostsBySingleTag($tag=false) {
        if ($tag) {
            global $dbTags;
            $totalPublishedPosts = $dbTags->countPostsByTag($tag);
            $posts = buildPostsForPage(0, $totalPublishedPosts, true, $tag);
            return $posts;
        } else {
            return $this->getAllPosts();
        }
    }

    public function getPostsByBlackList($tagList=false) {
        
        // get all posts
        global $dbPosts;
        $totalPublishedPosts = $dbPosts->numberPost(true);
        $posts = buildPostsForPage(0, $totalPublishedPosts, true, false);

        // besser explode  ',' und gucken ob subset !! 
        // do we need to Filter?
        if ($tagList) {
            // build a list of filtered posts
            $filteredPosts = [];
            foreach ($posts as $Post) {
                $addPost = true;
                foreach($tagList as $tag) {
                    if ( strtolower($Post->tags()) == strtolower($tag) ) {
                        $addPost = false;
                    }
                }
                if ( $addPost ) {
                    $filteredPosts[] = $Post;
                }
            }
        } else {
            $filteredPosts = $posts;
        }

        return $filteredPosts;

    }


    // returns a list of all posts
    public function getAllPosts() {
        return $this->getPostsByTagList(false);
    }


    // next and prev posts
    private function getNext($filteredPosts) {
        global $Post;
        foreach ($filteredPosts as $index=>$p) {
            if ($p->title() == $Post->title()) {
                if ($index + 1 > count($filteredPosts) - 1 ) {
                    return $filteredPosts[0];
                } else {
                    return $filteredPosts[$index + 1];
                }
            }
        }
    }
    private function getPrev($filteredPosts) {
        global $Post;
        foreach ($filteredPosts as $index=>$p) {
            if ($p->title() == $Post->title()) {
                if ( $index == 0) {
                    return $filteredPosts[count($filteredPosts) - 1];
                } else {
                    return $filteredPosts[$index - 1];
                }
            }
        }
    }
    public function getNextPostByTagList($tagList=false) {
        $filteredPosts = $this->getPostsByTagList($tagList);
        return $this->getNext($filteredPosts);
    }
    public function getPrevPostByTagList($tagList=false) {
        $filteredPosts = $this->getPostsByTagList($tagList);
        return $this->getPrev($filteredPosts);
    }
    public function getNextPostByBlackList($tagList=false) {
        $filteredPosts = $this->getPostsByBlackList($tagList);
        return $this->getNext($filteredPosts);
    }
    public function getPrevPostByBlackList($tagList=false) {
        $filteredPosts = $this->getPostsByBlackList($tagList);
        return $this->getPrev($filteredPosts);
    }


    public function form() {
        


        /*
        global $Language;

        $html = '<div>';
        $html .= '<label>'.$Language->get('scroll-text').'</label>';
        $html .= '<textarea name="text" id="jstext">'.$this->getDbField('text').'</textarea>';
        $html .= '</div>';
        $html .= '<div>';
        $html .= '<label>'.$Language->get('duration-text').'</label>';
        $html .= '<input type="number" name="duration" min="1" value="';
        $html .= $this->getDbField('duration');
        $html .= '">';
        $html .= '</div>';
        */
        $html = 'nothing here';

        return $html;
    }
}

?>
