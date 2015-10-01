# Best Match
![Test Coverage](http://img.shields.io/badge/coverage-100%25-green.svg)
[![Build Status](https://travis-ci.org/pdt256/bestmatch.svg?branch=master)](https://travis-ci.org/pdt256/bestmatch)
[![License](https://img.shields.io/github/license/pdt256/bestmatch.svg)](https://github.com/pdt256/bestmatch/blob/master/LICENSE.txt)

## Instructions

Find best set combination between subsets

## Description

Given the following sets: 

```
    Set1        Set2
    ----        ----
    red          blueviolet
    green        bluegreen
    blue         reed
```

Having the following percentages for string similarity:

```
    red|blueviolet|15
    red|bluegreen|33
    red|reed|86
    green|blueviolet|27
    green|bluegreen|71
    green|reed|67
    blue|blueviolet|57
    blue|bluegreen|62
    blue|reed|25
```

Best individual combinations (note: blueviolet not accounted for):

```
    red|reed|86
    green|bluegreen|71
    blue|bluegreen|62
```

Best set combinations:

```
    red|reed|86
    green|bluegreen|71
    blue|blueviolet|57
```

## Decision Tree

```
root
   red-blueviolet (15)
      green-bluegreen (71)
         blue-reed (25)
            [111]

      green-reed (67)
         blue-bluegreen (62)
            [144]

   red-bluegreen (33)
      green-blueviolet (27)
         blue-reed (25)
            [85]

      green-reed (67)
         blue-blueviolet (57)
            [157]

   red-reed (86)
      green-blueviolet (27)
         blue-bluegreen (62)
            [175]

      green-bluegreen (71)
         blue-blueviolet (57)
            [214]
```

## License

The MIT License (MIT)

Copyright (c) 2015 Jamie Isaacs <pdt256@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
