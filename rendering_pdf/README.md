# Rendering pdf and adding featrues using poppler and cairo 
<br>

## Compiling and Running 

g++ -o src/renderingPdf src/renderingPdf.cpp `pkg-config --cflags --libs cairo poppler-glib`

./src/renderingPdf "data/input.pdf" <br> <br>

## Details 

A new pdf is created as surface in cairo. <br>
An input pdf is rendered to cairo surface using poppler library and imposed to it. <br>
Some features are added to this pdf and the final pdf is produced. <br>
The size of this pdf is pretty close to the original one. <br> <br>

## Reference 

https://www.cairographics.org/cookbook/renderpdf/
