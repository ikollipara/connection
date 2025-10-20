{{--
Name:          empty.blade.php
Author:        Ian Kollipara
Created:       2025-09-30
Description:   Empty Search Page. Shown by default when you visit connection
--}}

<!DOCTYPE html>
<html data-theme="light"
      lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
  @vite(["resources/js/app.js", "resources/css/app.css"])
  <title>conneCTION</title>
</head>

<body>
  <section class="hero">
    <div class="hero-content text-center">
      <div class="max-w-md">
        <img src="/images/logo.png"
             alt="">
        <h1 class="text-5xl">conneCTION</h1>
        <p>Learn about CS, Together.</p>
        <form action="">
          <input class="input"
                 type="search">
          <button class="btn btn-primary rounded">Search</button>
          <div data-controller="combo-box"
               data-combo-box-name-value="grades[]"
               data-combo-box-label-value="Grades"
               data-combo-box-elements-value="{{ $grades }}"
               data-combo-box-multiple-value="true">
          </div>
          <select
            name="standards[]"
            data-select
            data-select-open-position="down"
            multiple>
            @foreach($standards as [$k, $v])
                <option value={{ $k }}>{{ $v }}</option>
            @endforeach
          </select>
        </form>
      </div>
    </div>
  </section>
</body>

</html>
