<?php

class Template
{
    public static function e($v): string
    {
        return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
    }

    public static function render(string $title, string $active, string $content): void
    {
        $menu = ['lecturers' => 'Lecturers', 'departments' => 'Departments', 'courses' => 'Courses'];
        echo '<!doctype html><html lang="en"><head><meta charset="utf-8">'
           . '<meta name="viewport" content="width=device-width, initial-scale=1">'
           . '<link href="assets/bootstrap.min.css" rel="stylesheet">'
           . '<title>' . self::e($title) . '</title></head><body>'
           . '<nav class="navbar navbar-expand navbar-dark bg-dark"><div class="container-fluid">'
           . '<a class="navbar-brand" href="index.php">Campus Data</a><ul class="navbar-nav">';
        foreach ($menu as $key => $label) {
            $cls = $key === $active ? 'nav-link active' : 'nav-link';
            echo "<li class='nav-item'><a class='$cls' href='index.php?entity=$key'>$label</a></li>";
        }
        echo '</ul></div></nav><div class="container my-4">' . $content . '</div>'
           . '<script src="assets/bootstrap.bundle.min.js"></script></body></html>';
    }

    public static function deleteForm(string $entity, int $id): string
    {
        return "<form method='post' action='index.php?entity=$entity&action=delete' class='d-inline' "
             . "onsubmit=\"return confirm('Hapus data ini?')\">"
             . "<input type='hidden' name='id' value='$id'>"
             . "<button class='btn btn-danger btn-sm'>Delete</button></form>";
    }

    public static function options(array $rows, string $labelKey, $selected, string $empty): string
    {
        $html = "<option value=''>" . self::e($empty) . "</option>";
        foreach ($rows as $r) {
            $sel = ((string)$selected === (string)$r['id']) ? ' selected' : '';
            $html .= "<option value='" . (int)$r['id'] . "'$sel>" . self::e($r[$labelKey]) . "</option>";
        }
        return $html;
    }
}
