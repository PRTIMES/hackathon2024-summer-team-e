import { Card, CardContent, Typography } from '@mui/material'

type ArticleCardProps = {
  title: string
  summary: string
  company_name: string
  url: string
}

const omit = (text: string) => (len: number) => (ellipsis: string) =>
  text.length >= len ? text.slice(0, len - ellipsis.length) + ellipsis : text

const ArticleCard = (props: ArticleCardProps) => {
  return (
    <Card
      sx={{
        backgroundColor: 'lightblue',
        mb: 4,
        p: 2,
        width: '100%',
        mx: 'auto',
      }}
    >
      <a href={props.url} target="_blank" rel="noopener noreferrer">
        <CardContent>
          <Typography
            variant="h6"
            component="div"
            sx={{
              mb: 2,
              fontWeight: 'bold',
              cursor: 'pointer',
              color: 'inherit',
              '&:hover': {
                textDecoration: 'underline',
              },
            }}
          >
            {omit(props.title)(45)('...')}
          </Typography>
          <Typography
            sx={{
              fontSize: 14,
            }}
          >
            {props.summary}
          </Typography>
          <Typography
            sx={{
              fontSize: 12,
            }}
          >
            {props.company_name}
          </Typography>
        </CardContent>
      </a>
    </Card>
  )
}

export default ArticleCard
