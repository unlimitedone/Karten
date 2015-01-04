<?php
/**
 * User: Immanuel Plath
 * Date: 05.12.14
 */

// Function pageHeader()
// function return head part of html page
// return: head part of html page
//=========================
function pageHeader($title)
{
    return '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Jugenstadtplan Leipzig">
    <meta name="author" content="Immanuel Plath">
    <link rel="icon" href="img/favicon.ico">

    <title>'.$title.'</title>
	
	<!-- Bootstrap core CSS -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link href="css/flag-icon.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	<!-- Include Map Css Styles -->
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
	
  </head>
  
  <body>';
}

// Function pageNavigation()
// function return navigation part of html page
// return: navigation part of html page
//=========================
function pageNavigation($label, $map, $aboutUs, $contact, $languageButton)
{
    return '
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">'.$label.'</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">'.$map.'</a></li>
            <li><a href="#about">'.$aboutUs.'</a></li>
            <li><a href="#contact">'.$contact.'</a></li>
          </ul>
		  <div class="col-sm-4 col-md-4">
            <form role="search" class="navbar-form">
                <div class="input-group col-xs-12">
                    <input id="searchfield" type="text" name="q" placeholder="Search" class="form-control">
                    <div class="input-group-btn">
                        <a class="btn btn-default startSearch"><i class="glyphicon glyphicon-search"></i></a>
                    </div>
                </div>
            </form>
		  </div>
		  <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#">'.$languageButton.' <b class="caret"></b> &nbsp <span class="flag-icon flag-icon-de"></span><span class="flag-icon flag-icon-gb"></span></a>
				<ul class="dropdown-menu">
					<li><a href="index.php"><span class="flag-icon flag-icon-de"></span> Deutsch</a></li>
					<li><a href="index.php?lang=en"><span class="flag-icon flag-icon-gb"></span> Englisch</a></li>
				</ul>
			</li>
		  </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

	';
}

// Function pageMap()
// function return map and location description
// return: map and location description page
//=========================
function pageMap($placeDescription, $opening, $contact, $properties, $chooseEntry, $lang)
{
    return '
    <div id="languageStore">'.$lang.'</div>
	<!-- Begin page content -->
    <div class="container">
	  <div class="row">
		<div class="col-md-12"">
			<div id="searchResponse" role="alert" class="alert alert-warning fade in hide">
				<strong>Sorry!</strong> for keyword: <strong>""</strong> we found <strong>0</strong> found search results.
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-9">
			 <div id="map"></div>
		</div>
		<!-- Sidebar Information for playces -->
		<div class="col-md-3" style="padding-left:0px;">
			<div class="thumbnail" style="height: 400px;">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									'.$placeDescription.'
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<div id="description">'.$chooseEntry.'</div>
							</div>
						</div>
					</div>				
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									'.$opening.'
								</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" style="max-height:215px;overflow:scroll;overflow-x:hidden;">
							<div class="panel-body">
								<div id="opening">'.$chooseEntry.'</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									'.$contact.'
								</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" style="max-height:215px;overflow:scroll;overflow-x:hidden;">
							<div class="panel-body">
								<div id="contact">'.$chooseEntry.'</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFour">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									'.$properties.'
								</a>
							</h4>
						</div>
						<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" style="max-height:215px;overflow:scroll;overflow-x:hidden;">
							<div class="panel-body">
								<div id="properties">'.$chooseEntry.'</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	  </div>

';
}

// Function pageCategories()
// function return all categories and properties
// return: categories and properties page
//=========================
function pageCategories($menuCategories, $categoriesContent, $standardCatOne, $standardCatTwo)
{
    return '
	  <div class="row">
	    <!-- choose categories -->
		<div class="col-md-12">
			 <div class="thumbnail">
				<ul role="tablist" class="nav nav-tabs" id="myTab">
					<li class="active" role="presentation"><a aria-expanded="true" aria-controls="home0" data-toggle="tab" role="tab" id="home0-tab" href="#home0" onclick=\'allLocations(true);\'>'.$standardCatOne.'</a></li>
					<li role="presentation" class=""><a aria-controls="home1" data-toggle="tab" id="home1-tab" role="tab" href="#home1" aria-expanded="false" onclick=\'getGroupLocations("nocategory");\'>'.$standardCatTwo.'</a></li>
					'.$menuCategories.'
				</ul>
	
				<div class="tab-content" id="myTabContent">
					<div aria-labelledby="home0-tab" id="home0" class="tab-pane fade active in" role="tabpanel">
						<!-- <p>All places here ...</p> -->
					</div>
					<div aria-labelledby="home1-tab" id="home1" class="tab-pane fade" role="tabpanel">
						<!-- <p>Keine Kategorie here ...</p> -->
					</div>'.$categoriesContent.'
				</div>
			 </div>
		</div>
	  </div>
    </div>

	';
}

// Function pageCategories()
// function return footer and end of page
// return: website footer and end of page
//=========================
function pageFooter($copyright, $copyrightdate)
{
    return '
	<!-- Begin footer content -->
    <div class="footer">
      <div class="container">
        <p class="text-muted">&copy; '.$copyright.' '.$copyrightdate.' </p>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	
	<!-- Custom JavaScript
    ================================================== -->
	<!-- Include Map JS -->
	<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
	<!-- Custom JS Settings for Map -->
	<script src="js/custom-map.js"></script>
	<!-- Helper JS Functions -->
	<script src="js/helper.js"></script>
	
  </body>
</html>';
}

?>



