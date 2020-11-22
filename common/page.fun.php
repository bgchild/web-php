<?php
 /*
 *  分页函数
*/
/*    function _get_page($page_per = 10)
    {
        $page = empty($_REQUEST['page']) ? 1 : intval($_REQUEST['page']);
        $start = ($page -1) * $page_per;

        return array('limit' => "{$start},{$page_per}", 'curr_page' => $page, 'pageper' => $page_per);
    }
*/
/*
 * 添加一个cur_page参数，对于原有使用无影响 --- edited by 张英姿 2013-07-12
 * */
    function _get_page($page_per = 10,$cur_page=0)
    {
        $page = empty($_REQUEST['page']) ? 1 : intval($_REQUEST['page']);
        $start = ($page -1) * $page_per;
        
		if($cur_page) $page=$cur_page;
        
        return array('limit' => "{$start},{$page_per}", 'curr_page' => $page, 'pageper' => $page_per);
    }


    /**
     * 格式化分页信息
     * @param   array   $page
     * @param   int     $num    显示几页的链接
     */
    function _format_page($page, $num = 10)
    {
        $page['page_count'] = ceil($page['item_count'] / $page['pageper']);
        $mid = ceil($num / 2) - 1;
        if ($page['page_count'] <= $num)
        {
            $from = 1;
            $to   = $page['page_count'];
        }
        else
        {
            $from = $page['curr_page'] <= $mid ? 1 : $page['curr_page'] - $mid;
            $to   = $from + $num - 1;
            $to > $page['page_count'] && $to = $page['page_count'];
        }
        /* URL */
        if (preg_match('/[&|\?]?page=\w+/i', $_SERVER['QUERY_STRING']) > 0)
        {
            $url_format = preg_replace('/[&|\?]?page=\w+/i', '', $_SERVER['QUERY_STRING']);
        }
        else
        {
            $url_format = $_SERVER['QUERY_STRING'];
        }
        $page['page_links'] = array();
       for ($i = $from; $i <= $to; $i++)
        {
            $page['page_links'][$i] = "?{$url_format}&page={$i}";
        }
        $page['prev_link'] = $page['curr_page'] > $from ? "?{$url_format}&page=" . ($page['curr_page'] - 1) : "";
        $page['next_link'] = $page['curr_page'] < $to ? "?{$url_format}&page=" . ($page['curr_page'] + 1) : "";
		$page['url_format'] = "{$url_format}";
		$page['first_link']="?{$url_format}&page=1";
		$page['last_link']="?{$url_format}&page=".($page['page_count']);
		return $page;
    }

/**
 * 分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $pageurls 链接地址
 * @return 分页
 */
function content_pages($num, $curr_page,$pageurls) {

	$multipage = '';
	$page = 11;
	$offset = 4;
	$pages = $num;
	$from = $curr_page - $offset;
	$to = $curr_page + $offset;
	$more = 0;
	if($page >= $pages) {
		$from = 2;
		$to = $pages-1;
	} else {
		if($from <= 1) {
			$to = $page-1;
			$from = 2;
		} elseif($to >= $pages) {
			$from = $pages-($page-2);
			$to = $pages-1;
		}
		$more = 1;
	}
	
	if($curr_page>0) {
		$perpage = $curr_page == 1 ? 1 : $curr_page-1;
		$multipage .= '<a class="a1" href="'.$pageurls[$perpage][0].'">上一页</a>';
		if($curr_page==1) {
			$multipage .= ' <span>1</span>';
		} elseif($curr_page>6 && $more) {
			$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>..';
		} else {
			$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>';
		}
	}
	for($i = $from; $i <= $to; $i++) {
		if($i != $curr_page) {
			$multipage .= ' <a href="'.$pageurls[$i][0].'">'.$i.'</a>';
		} else {
			$multipage .= ' <span>'.$i.'</span>';
		}
	}
	if($curr_page<$pages) {
		if($curr_page<$pages-5 && $more) {
			$multipage .= ' ..<a href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a class="a1" href="'.$pageurls[$curr_page+1][0].'">下一页</a>';
		} else {
			$multipage .= ' <a href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a class="a1" href="'.$pageurls[$curr_page+1][0].'">下一页</a>';
		}
	} elseif($curr_page==$pages) {
		$multipage .= ' <span>'.$pages.'</span> <a class="a1" href="'.$pageurls[$curr_page][0].'">下一页</a>';
	}
	
	return $multipage;
}


?>