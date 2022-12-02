// header files
#include <iostream>
#include <vector>
#include <poppler.h>           // for rendering pdfs
#include <cairo.h>             // for cairo surface and annotating it
#include <cairo-pdf.h>         // for returning surface as pdf

using namespace std;

int main(int argc, char *argv[])
{
    PopplerDocument *document;
    PopplerPage *page;
    cairo_surface_t *surface;
    cairo_t *cr;
    gchar *absolute;
    GError *error = NULL;
    double width, height;    
    vector <vector <int>> points = {{245, 250}, {265, 270}, {320, 200}};

    // file for redering as surface
    const char* filename = argv[1];
    if (g_path_is_absolute(filename)) {
        absolute = g_strdup (filename);
    } 
    else {
        gchar *dir = g_get_current_dir ();
        absolute = g_build_filename (dir, filename, (gchar *) 0);
        free (dir);
    }

    gchar *uri = g_filename_to_uri (absolute, NULL, &error);
    if (uri == NULL) {
        cout << error->message;
        return 1;
    }

    document = poppler_document_new_from_file (uri, NULL, &error);
    if (document == NULL) {
        cout << error->message;
        return 1;
    }

    int num_pages = poppler_document_get_n_pages (document);
    if (num_pages != 1) {
        cout << "page must be " << num_pages;
        return 1;
    }

    page = poppler_document_get_page (document, 0);
    if (page == NULL) {
        cout << "poppler fail: page not found\n";
        return 1;
    }

    poppler_page_get_size (page, &width, &height);

    // file that is being returned
    filename = "output/output.pdf";

    surface = cairo_pdf_surface_create(filename, width, height);
    cr = cairo_create (surface);
    cairo_save (cr);
    poppler_page_render (page, cr);
    cairo_restore (cr);
    g_object_unref (page);

    // red color
    cairo_set_source_rgb(cr, 1.0, 0.0, 0.0);
    cairo_set_line_width(cr, 2);

    // rectangle
    cairo_rectangle(cr, 40, 40, 80, 41);
    cairo_stroke_preserve(cr);
    cairo_fill(cr);

    // tick mark
    for (int j = 0; j <= 200; j += 200) {
        cairo_move_to(cr, j + points[0][0], j + points[0][1]);
        for (int i = 0; i < points.size(); i++)
            cairo_line_to(cr, points[i][0] + j, points[i][1] + j);
        cairo_stroke_preserve(cr);
    }
    cairo_move_to(cr, 300 + points[0][0], points[0][1] - 50);
    for (int i = 0; i < points.size(); i++)
            cairo_line_to(cr, points[i][0] + 300, points[i][1] - 50);
    cairo_stroke_preserve(cr);
    
    // freing spaces
    free (absolute);
    cairo_destroy (cr);
    cairo_surface_destroy (surface);
    g_object_unref (document);

    return 0;
}