<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <meta name="description" content="Hello BitClout in PHP" />
    <title>Hello BitClout - PHP</title>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css"  rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/app.css">
  </head>
  <body>
      <div class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container">
            <a class="navbar-brand" href="/"><img src="assets/logo.svg" alt="BitClout Logo"/></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-flex">
                <button class="btn hover-primary btn-dark text-uppercase" onclick="login()" id="login" type="button">Sign in with BitClout</button>
                <button class="btn hover-primary btn-dark text-uppercase" onclick="logout()" id="logout" style="display:none" type="button">Log Out</button>
            </div>
          </div>
        </nav>
      </div>
      <div class="container">
        <div class="row my-5">
          <div class="col-md-8 col-sm-12 offset-md-2">
            <div class="form-card">
              <div class="post-form">
                <div class="form-group flex-row  d-flex">
                  <div class="userImage"><img class="rounded" src="https://tijn.club/assets/img/default_profile_pic.png"></div>
                  <div class="flex-fill"><textarea class="form-control" id="postText" autocomplete="off" placeholder="I'm king of the world!"></textarea></div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn hover-primary btn-dark text-uppercase" id="postSubmit" onclick="post()" style="display:none" type="button">Post</button>
                </div>
              </div>
              <div class="posts-list mt-5">
                <div class="loader" style="display:none">
                  <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
                <div id="posts"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </body>
  <iframe id="identity" frameborder="0" src="https://identity.bitclout.com/embed" style="height: 100vh; width: 100vw; display: none"></iframe>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  <script src="assets/app.js"></script>
</html>