<?php namespace App\Http\Middleware;

use Closure;

class Redirects
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->ajax() && $request->isMethodSafe(false)) {
            $rules = $this->getRuleList();
            $path = $this->normalizePath(\Request::getRequestUri());

            foreach ($rules as $rule => $redirectTo) {
                if (@preg_match("@{$rule}@", $path)) {
                    return redirect()->to($redirectTo, 301);
                }
            }
        }

        return $next($request);
    }


    /**
     * Get list of redirect rules.
     *
     * @return array
     */
    private function getRuleList()
    {
        $rules = [];

        $rows = \Setting::get('redirects_rules');

        if (is_array($rows)) {
            foreach ($rows as $row) {
                $rule = trim($row['rule']);
                if (!empty($rule)) {
                    $rules[$rule] = $this->normalizePath($row['url']);
                }
            }
        }

        return $rules;
    }


    /**
     * Normalize url path.
     *
     * @param $path
     * @return string
     */
    private function normalizePath($path)
    {
        return urldecode('/' . trim(trim($path, '/')));
    }
}
