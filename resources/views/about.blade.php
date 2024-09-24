{{--
file: resources/views/about.blade.php
author: Ian Kollipara
date: 2024-09-08
description: This is the about page for the website.
 --}}

<x-guest-layout title="About">
  <section class="bg-white dark:bg-gray-900">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
      <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">About Us</h2>
      <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">
        AIR@NE was a NSF-funded grant that examined the adaptation and implementation of a validated K-8
        Computer Science curriculum in diverse school districts. The grant expanded the
        Research-Practitioner Partnership between the University of Nebraska-Lincoln and Lincoln Public
        Schools (LPS) to other districts across Nebraska. <br><br>The primary goal was to study how
        districts facing different contextual challenges, including rural schools, majority-minority
        schools, and Native American reservation schools, adapt the curriculum to fit local needs and
        strengths to broaden participation in computer science.
      </p>
      <img class="rounded max-w-screen-md mx-auto mb-8 lg:mb-16"
           src="images/airne_personnel.webp"
           alt="">
      <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">
        AIR@NE connected teachers across the state of Nebraska, from the panhandle to Omaha and Lincoln.
        This statewide community helped connect CS teachers to other CS teachers. It created a place to
        learn and grow that wasn't bound by distance. <br><br>As more states add CS to their standards, we
        realized there might be a spot for an online PLC, centered around CS.
      </p>
      <img class="rounded max-w-screen-md mx-auto"
           src="images/AIRNE-C1-5-MAP.webp"
           alt="">
    </div>
  </section>
</x-guest-layout>
