import {
  RichText,
  getColorClassName,
  useBlockProps,
} from '@wordpress/block-editor';
import classnames from 'classnames';

const MICRO_COPY_CLASS = 'micro-copy';

export default function save( { attributes } ) {
  const { content, type, icon, textColor, customTextColor } = attributes;

  const textClass = getColorClassName( 'color', textColor );

  const className = classnames( {
    [ 'micro-text' ]: true,
    [ MICRO_COPY_CLASS ]: true,
    [ type ]: !! type,
    'has-text-color': textColor || customTextColor,
    [ textClass ]: textClass,
  } );

  const styles = {
    '--cocoon-custom-text-color': customTextColor || undefined,
  };

  const blockProps = useBlockProps.save( {
    className: className,
    style: styles,
  } );

  return (
    <div { ...blockProps }>
      <span className="micro-text-content micro-content">
        { icon && (
          <span
            className={ classnames( 'micro-text-icon', 'micro-icon', icon ) }
          ></span>
        ) }
        <RichText.Content value={ content } />
      </span>
    </div>
  );
}
